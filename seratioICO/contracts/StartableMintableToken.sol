pragma solidity ^0.4.8;

import '../node_modules/zeppelin-solidity/contracts/token/MintableToken.sol';
import './lifecycle/Startable.sol';

/**
 * Startable token
 *
 * Simple ERC20 Token example, with mintable token creation and startable mechanism
 * Issue:
 * https://github.com/OpenZeppelin/zeppelin-solidity/issues/194
 * Based on code by BCAPtoken:
 * https://github.com/BCAPtoken/BCAPToken/blob/5cb5e76338cc47343ba9268663a915337c8b268e/sol/BCAPToken.sol#L27
 **/

contract StartableMintableToken is Startable, MintableToken {

    function transfer(address _to, uint _value) whenNotPaused returns (bool){
        return super.transfer(_to, _value);
    }

    function transferFrom(address _from, address _to, uint256 _value) whenNotPaused returns (bool) {
        return super.transferFrom(_from, _to, _value);
    }
}