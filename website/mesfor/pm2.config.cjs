module.exports = {
  apps : [{
    name: "mesfor",
    script: "index.js",
    // exec_mode : 'cluster',
    // instances : 'max',
    autorestart: true,
    max_memory_restart: '4G'
  }]
};
