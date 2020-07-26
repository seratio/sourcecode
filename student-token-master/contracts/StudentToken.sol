pragma solidity ^0.4.23;

import "openzeppelin-solidity/contracts/token/ERC20/StandardBurnableToken.sol";
import "openzeppelin-solidity/contracts/token/ERC20/MintableToken.sol";
import "openzeppelin-solidity/contracts/token/ERC20/DetailedERC20.sol";

contract StudentToken is StandardBurnableToken, MintableToken, DetailedERC20{
    constructor()
    DetailedERC20('Student Coin', 'STC', 7)
    public {
    }
}
