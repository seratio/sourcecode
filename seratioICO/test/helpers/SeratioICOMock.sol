pragma solidity ^0.4.8;

import '../../contracts/SeratioICO.sol';

// mock class using SeratioCoin
contract SeratioICOMock is SeratioICO {

    uint public oneDay = 1 days;

    function SeratioICOMock(uint timeStampOfCrowdSaleStart, address depositAccount)
    SeratioICO(depositAccount, timeStampOfCrowdSaleStart)
    {}

}