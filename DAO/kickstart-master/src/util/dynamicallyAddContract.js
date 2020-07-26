module.exports = async (contractObject, drizzle, account) => {
  async function loadContract(contractObject, provider, address) {
    const TruffleContract = require("truffle-contract");
    let contract = TruffleContract(contractObject);
    contract.setProvider(provider);
    /**
     * Implements workaround this issue
     * https://github.com/trufflesuite/truffle-contract/issues/57
     */
    if (typeof contract.currentProvider.sendAsync !== "function") {
      contract.currentProvider.sendAsync = function() {
        return contract.currentProvider.send.apply(
          contract.currentProvider,
          arguments
        );
      };
    }
    contract.defaults({
      from: address,
      gas: 4500000
    });
    return contract.deployed();
  }

  let truffleContract = await loadContract(
    contractObject,
    drizzle.web3.currentProvider,
    account
  );

  let createNewContractInstance = false;
  let contractConfig = {
    contractName: contractObject.contractName,
    web3Contract: createNewContractInstance
      ? new this.drizzle.web3.eth.Contract(
          truffleContract.abi,
          truffleContract.address
        )
      : truffleContract.contract
  };
  let events = {
    // SimpleStorage: ["StorageSet"]
  };

  try {
    let useAnAction = false;
    useAnAction
      ? // Using an action
        drizzle.store.dispatch({
          type: "ADD_CONTRACT",
          drizzle: this.drizzle,
          contractConfig: contractConfig,
          events: events,
          web3: drizzle.web3
        })
      : // Or using the Drizzle context object
        drizzle.addContract(contractObject, { contractConfig, events });
  } catch (err) {
    console.log(err);
  }
};
