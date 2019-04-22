'use strict';

import $ from 'jquery';
import FastAverageColor from 'fast-average-color/dist/index.es6';
import Foundation from 'foundation-sites';
import Masonry from 'masonry-layout';
import Raven from 'raven-js';

Foundation.addToJquery($);

(function workColors() {
  const fac = new FastAverageColor();
  // Target container
  const workArchive = document.querySelector('#archive');
  if(typeof(workArchive) != 'undefined' && workArchive != null) {
    const articleImages = workArchive.querySelectorAll('img');

    const msnry = new Masonry( workArchive, {
      columnWidth: '.grid-sizer',
      itemSelector: '.hentry',
      percentPosition: true,
    });
    msnry.on('layoutComplete', () => {
      console.log('layout done');
    });

    let stylesheet = document.createElement('style');
        stylesheet.appendChild(document.createTextNode(""));
        document.head.appendChild(stylesheet);
        stylesheet = stylesheet.sheet;

    let i = 0;

    articleImages.forEach(function(image) {
      i++;

      fac.getColorAsync(image, function(color) {
        const regExp = /post-([0-9]+)/;
        const postID = regExp.exec(this.closest('.hentry').className);
        const target = '.' + postID[0] + '::before';
        const from = 'rgba(' + color.value[0] + ',' + color.value[1] + ',' + color.value[2] + ',0)';
        const to = 'rgba(' + color.value[0] + ',' + color.value[1] + ',' + color.value[2] + ',1)';

        // let style = 'background-image: -webkit-gradient(linear, left top, left bottom, from(' + from + '), to(' + to + ')) !important; background-image: linear-gradient(top, ' + from + ' 0%, ' + to + ' 100%) !important;';
        let style = 'background-color:' + to;

        return stylesheet.addRule(target, style);
      });
    });
  } else {

    return false;

  }
})();

//height fix
if (Foundation.MediaQuery.is('small only')) {
  window.onresize = () => {
    const height = window.innerHeight - $('.topbar').height();

    $('.main .container>.hentry .header').height(height);
    $('.main .container>.hentry.page').height(height);
  }
  window.onresize(); // called to initially set the height.
}

if (process.env.NODE_ENV === 'production') {
  Raven.config(process.env.SENTRY_DSN).install();

  (function(w,d,s,l,i){
    w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});let f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer',process.env.GTM);
}
