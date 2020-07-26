var GuessNumber = artifacts.require("./GuessNumber.sol");

module.exports = function(deployer) {
  deployer.deploy(GuessNumber);
};
