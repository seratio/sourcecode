pragma solidity ^0.4.13;
import "contracts/token/ERC827/MintableBurnableERC827Token.sol";

contract Microshares is MintableBurnableERC827Token{
    // Name of the token
    string constant public name = "Microshares";
    // Token abbreviation
    string constant public symbol = "MCR";
    // Decimal places
    uint8 constant public decimals = 18;
}
