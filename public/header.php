<!DOCTYPE html>
<html <?php language_attributes(); ?> class="disruptv">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <?php wp_head(); ?>
    <script>
      (function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
        var f = d.getElementsByTagName(s)[0],
          j = d.createElement(s),
          dl = l != "dataLayer" ? "&l=" + l : "";
        j.async = true;
        j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, "script", "dataLayer", "%REACT_APP_GTM_ID%");
    </script>
    <%= htmlWebpackPlugin.tags.headTags %>
  </head>
  <body <?php body_class(); ?>>
    <noscript
      ><iframe
        src="https://www.googletagmanager.com/ns.html?id=%REACT_APP_GTM_ID%"
        height="0"
        width="0"
        style="display: none; visibility: hidden"
      ></iframe>
      You need to enable JavaScript to run this app.
    </noscript>
    <div id="root">
