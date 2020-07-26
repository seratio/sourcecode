module.exports = {
  networks: {
    development: {
      host: "localhost",
      port: 8545,
      network_id: "*" // Match any network id
    },
     bumblebee: {
      host: "bumblebee.markuplab.net",
      port: 8042,
      network_id: "*" // Match any network id
    }
  }
};
