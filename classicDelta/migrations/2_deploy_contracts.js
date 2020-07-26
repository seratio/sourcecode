var ClassicDelta = artifacts.require("ClassicDelta");

// NOTE: Use this file to easily deploy the contracts you're writing.
//   (but make sure to reset this file before committing
//    with `git checkout HEAD -- migrations/2_deploy_contracts.js`)

module.exports = function (deployer) {
  const admin = "0x2cB00324a6B9Eb1756770beF05Dc83FE2D375090";
  const feeAccount = "0xd1900dA6020324e24327c7B5b16526f201929fE3";
  const accountLevelsAddr = 0x0000000000000000000000000000000000000000;
  const feeMake = 0;
  const feeTake = 3000000000000000;
  const feeRebate = 0;

  deployer.deploy(ClassicDelta, admin, feeAccount, accountLevelsAddr, feeMake, feeTake, feeRebate);
};
