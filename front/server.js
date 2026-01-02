const path = require('path');
const express = require('express');
const { createRenderer } = require('vue-server-renderer');

// Bundle server-side generado por webpack (entry-server.js)
const createApp = require('./dist/server/server.bundle.js').default;
const clientBundlePath = '/dist/client/client.bundle.js';

const renderer = createRenderer({
  template: `
  <!DOCTYPE html>
  <html>
  <head><meta charset="utf-8"><title>Valuation SSR</title></head>
  <body>
    <div id="app"><!--vue-ssr-outlet--></div>
    <script>window.__INITIAL_STATE__ = {};</script>
    <script src="${clientBundlePath}"></script>
  </body>
  </html>`
});

const app = express();
app.use('/dist/client', express.static(path.join(__dirname, 'dist/client')));

// Express 5 usa path-to-regexp v6; el comodín debe ser un patrón válido (.*)
// Ruta comodín compatible con path-to-regexp v6 (Express 5)
app.get(/.*/, (req, res) => {
  const context = { url: req.url, state: {} };
  try {
    const appVm = createApp(context); // devuelve instancia Vue
    renderer.renderToString(appVm, (err, html) => {
      if (err) {
        console.error(err);
        return res.status(500).send('SSR error');
      }
      // insertamos html ya que template tiene outlet
      res.send(html);
    });
  } catch (err) {
    console.error(err);
    return res.status(500).send('SSR error');
  }
});

const port = process.env.PORT || 3000;
app.listen(port, () => console.log(`SSR running at http://localhost:${port}`));

