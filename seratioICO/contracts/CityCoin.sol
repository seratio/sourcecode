pragma solidity ^0.4.8;

import '../node_modules/zeppelin-solidity/contracts/token/MintableToken.sol';

contract CityCoin is MintableToken {
    // Name of the token
    string constant public name = "CityCoin";
    // Token abbreviation
    string constant public symbol = "CIT";
    // Decimal places
    uint8 constant public decimals = 7;
    // Zeros after the point
    uint32 constant public DECIMAL_ZEROS = 10000000;
}
