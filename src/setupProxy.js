const { createProxyMiddleware } = require("http-proxy-middleware");

module.exports = function (app) {
  app.use(
    "index.php",
    createProxyMiddleware({
      target: process.env.PROXY || "http://localhost:3000",
      changeOrigin: true,
      ws: true,
    })
  );
};
