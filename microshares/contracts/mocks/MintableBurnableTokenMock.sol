pragma solidity ^0.4.13;


import "../token/ERC20/MintableBurnableToken.sol";


// mock class using ERC827 Token
contract MintableBurnableTokenMock is MintableBurnableToken {

  function MintableBurnableTokenMock(address initialAccount, uint256 initialBalance) public {
    balances[initialAccount] = initialBalance;
    totalSupply_ = initialBalance;
  }

}
