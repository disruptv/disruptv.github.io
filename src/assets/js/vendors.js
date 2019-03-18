'use strict';

import $ from 'jquery';
import FastAverageColor from 'fast-average-color/dist/index.es6';
import Foundation from 'foundation-sites';
import Masonry from 'masonry-layout';

Foundation.addToJquery($);
$(document).foundation();

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
