pragma solidity ^0.4.23;

import "../StudentToken.sol";


contract StudentTokenMock is StudentToken {

    constructor(address initialAccount, uint initialBalance) public {
        balances[initialAccount] = initialBalance;
        totalSupply_ = initialBalance;
    }

}
