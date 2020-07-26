pragma solidity ^0.4.18;

import "../token/ERC827/MintableBurnableERC827Token.sol";


contract MintableBurnableERC827TokenMock is MintableBurnableERC827Token {

  function MintableBurnableERC827TokenMock(address initialAccount, uint initialBalance) public {
    balances[initialAccount] = initialBalance;
    totalSupply_ = initialBalance;
  }

}
