require("dotenv").config();
require("babel-register");
require("babel-polyfill");

const HDWalletProvider = require("truffle-hdwallet-provider");

const providerWithMnemonic = (mnemonic, rpcEndpoint) =>
  new HDWalletProvider(mnemonic, rpcEndpoint, 0, 1); //, process.env.PASSWORD);

const infuraProvider = network =>
  providerWithMnemonic(
    process.env.MNEMONIC || "",
    `https://${network}.infura.io/${process.env.INFURA_API_KEY}`
  );

const ropstenProvider = process.env.SOLIDITY_COVERAGE
  ? undefined
  : infuraProvider("ropsten");

module.exports = {
  networks: {
    customMainnet: {
      provider: providerWithMnemonic(
        process.env.MNEMONIC,
        process.env.ENDPOINT + process.env.ENDPOINT_POSFIX
      ),
      network_id: 1, // eslint-disable-line camelcase
      gas: 4605201,
      gasPrice: 4000000000
    },
    development: {
      host: "localhost",
      port: 9545,
      network_id: "*" // eslint-disable-line camelcase
    },
    infuraMainnet: {
      provider: infuraProvider("mainnet"),
      network_id: 1, // eslint-disable-line camelcase
      gas: 4605201,
      gasPrice: 10000000000
    },
    ropsten: {
      provider: ropstenProvider,
      network_id: 3, // eslint-disable-line camelcase
      gas: 4605201,
      gasPrice: 10000000000
    },
    coverage: {
      host: "localhost",
      network_id: "*", // eslint-disable-line camelcase
      port: 8555,
      gas: 0xfffffffffff,
      gasPrice: 0x01
    },
    testrpc: {
      host: "localhost",
      port: 8545,
      network_id: "*" // eslint-disable-line camelcase
    },
    ganache: {
      host: "localhost",
      port: 7545,
      network_id: "*" // eslint-disable-line camelcase
    }
  },
  solc: {
    optimizer: {
      enabled: true,
      runs: 200
    }
  }
};
