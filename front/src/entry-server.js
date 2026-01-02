import { createApp } from './app';
export default context => {
  const { app } = createApp(context.state || {});
  return app;
};
