<!DOCTYPE html>
<html <?php language_attributes(); ?> class="disruptv">
  <head>
    <?php wp_head(); ?>
    <link rel="icon" href="%PUBLIC_URL%/wp-content/themes/dist/static/media/disruptv-icon--onLight192.png" />
    <meta name="theme-color" content="#000000" />
    <meta
    name="description"
      content="Disruptv, New York | Digital Strategy, Design, Development, Content & Management"
    />
    <link rel="apple-touch-icon" href="%PUBLIC_URL%/wp-content/themes/dist/static/media/disruptv-icon--onDark192.png" />

    <link rel="manifest" href="%PUBLIC_URL%/wp-content/themes/dist/manifest.json" />
    <%= htmlWebpackPlugin.tags.headTags %>
  </head>
  <body <?php body_class(); ?>>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root">
