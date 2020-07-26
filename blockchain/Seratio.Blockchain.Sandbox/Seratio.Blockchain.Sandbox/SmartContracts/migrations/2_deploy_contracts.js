var Token = artifacts.require("./Token.sol");
var CityCoin = artifacts.require("./CityCoin.sol");
var EduCoin = artifacts.require("./EduCoin.sol");
var MuslimCoin = artifacts.require("./MuslimCoin.sol");
var SDGCoin = artifacts.require("./SDGCoin.sol");
var WomenCoin = artifacts.require("./WomenCoin.sol");

module.exports = function (deployer) {
  deployer.deploy(Token);
  deployer.link(Token, CityCoin);
  deployer.link(Token, EduCoin);
  deployer.link(Token, MuslimCoin);
  deployer.link(Token, SDGCoin);
  deployer.link(Token, WomenCoin);
  deployer.deploy(CityCoin, 1000000000);
  deployer.deploy(EduCoin, 1000000000);
  deployer.deploy(MuslimCoin, 1000000000);
  deployer.deploy(SDGCoin, 1000000000);
  deployer.deploy(WomenCoin, 1000000000);
};
