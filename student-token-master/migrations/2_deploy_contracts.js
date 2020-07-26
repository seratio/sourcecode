var StudentCoinCrowdsale = artifacts.require("StudentCoinCrowdsale");

/**
 * Follow this pattern to workaround the following problem:
 * https://github.com/trufflesuite/truffle/issues/501
 */

module.exports = deployer => {
  // Alternatively, just start a chain without a deployment
  deployer.then(async () => {
    let studentCoinCrowdsale = await deployer.deploy(
      StudentCoinCrowdsale,
      3322,
      "0xcf799f18f21bf17766386cb8713654058565b3c1"
    );
    // await studentCoinCrowdsale.buyTokens(
    //   "0xcf799f18f21bf17766386cb8713654058565b3c1",
    //   {
    //     value: web3.toWei(1, "ether")
    //   }
    // );
  });
};
