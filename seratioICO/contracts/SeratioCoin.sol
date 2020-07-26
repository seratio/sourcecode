pragma solidity ^0.4.8;

import './StartableMintableToken.sol';

contract SeratioCoin is StartableMintableToken {
    // Name of the token
    string constant public name = "SeratioCoin";
    // Token abbreviation
    string constant public symbol = "SER";
    // Decimal places
    uint8 constant public decimals = 7;
    // Zeros after the point
    uint32 constant public DECIMAL_ZEROS = 10000000;
}
