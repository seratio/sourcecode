var SeratioICO = artifacts.require("./SeratioICO.sol");
var SeratioCoin = artifacts.require("./SeratioCoin.sol");
module.exports = function (deployer) {
    let timestampOfCrowdsaleStart = + new Date("Fri Sep 15 2017 00:00:00 GMT+0100")/1000 | 0;
    // console.log(timestampOfCrowdsaleStart);
    deployer.deploy(SeratioICO, "0x78D94fBce21b84c8a173b07988017DF5637f2Bc2", timestampOfCrowdsaleStart);
}
