pragma solidity ^0.4.11;

import '../../contracts/SeratioCoin.sol';

contract SeratioCoinMock is SeratioCoin {
    function SeratioCoinMock(address initialAccount, uint initialBalance) {
        balances[initialAccount] = initialBalance;
    }
}