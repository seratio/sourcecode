pragma solidity ^0.4.8;

import './SeratioCoin.sol';
import '../node_modules/zeppelin-solidity/contracts/math/SafeMath.sol';
import '../node_modules/zeppelin-solidity/contracts/ownership/Ownable.sol';

/**
 *
 * @title Seratio Stake
 *
 * TODO Whitepaper https://github.com/seratio/whitepaper/blob/master/Seratio%20Enterprise%20Platform%20(29%20March%202017)%20%5Bv.%204.03%5D.pdf
 *
 */
contract SeratioICO is Ownable{
    using SafeMath for uint;

    // logged events:
    // Funds has arrived into the wallet (record how much).
    event DepositAcceptedEvent(address _from, uint value);

    // Minimum investment ICO phase one
    uint16 constant public MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS = 5000;
    // Minimum investment ICO phase two
    uint16 constant public MIN_INVESTMENT_ICO_PHASE_TWO_POUNDS = 1000;
    // Investment cap ICO phase one
    uint32 constant public INVESTMENT_CAP_ICO_PHASE_ONE_POUNDS = 1000000;
    // Investment cap ICO phase two
    uint32 public investmentCapIcoPhaseTwoPounds = 4000000000;
    // Base toke price in pound pences
    uint8 constant BASE_TOKEN_PRICE_IN_POUND_PENCES = 20;

    bool investmentCapPreIcoReached = false;

    // Total value in wei
    uint totalValue;

    uint public timeStampOfCrowdSaleStart;
    uint public timeStampOfCrowdSaleEnd;

    // Address of multisig wallet holding ether from sale
    address wallet;

    struct IcoPhaseOneConfig{
    uint startingTime;
    uint8 tokenPriceInPoundPences;
    }

    IcoPhaseOneConfig[] IcoPhaseOneArray;

    uint32 public etherPriceInPoundPences = 30000;

    SeratioCoin public seratioCoin;

    /**
     * Constructor of the contract.
     *
     * Passes address of the account holding the value.
     * SeratioCoin contract itself does not hold any value
     *
     * @param multisig address of MultiSig wallet which will hold the value
     */
    function SeratioICO(address multisig, uint _timeStampOfCrowdSaleStart){
        seratioCoin = new SeratioCoin();

        timeStampOfCrowdSaleStart = _timeStampOfCrowdSaleStart;
        timeStampOfCrowdSaleEnd = timeStampOfCrowdSaleStart + 47 days;

        wallet = multisig;

        IcoPhaseOneArray.push(IcoPhaseOneConfig({startingTime: timeStampOfCrowdSaleStart +  0 days,  tokenPriceInPoundPences:  10})); // from  1st day to  3rd day -> 50% discount
        IcoPhaseOneArray.push(IcoPhaseOneConfig({startingTime: timeStampOfCrowdSaleStart +  3 days,  tokenPriceInPoundPences:  12})); // from  4th day to  6th day -> 40% discount
        IcoPhaseOneArray.push(IcoPhaseOneConfig({startingTime: timeStampOfCrowdSaleStart +  6 days,  tokenPriceInPoundPences:  14})); // from  7th day to  9th day -> 30% discount
        IcoPhaseOneArray.push(IcoPhaseOneConfig({startingTime: timeStampOfCrowdSaleStart +  9 days,  tokenPriceInPoundPences:  16})); // from 10th day to 12th day -> 20% discount
        IcoPhaseOneArray.push(IcoPhaseOneConfig({startingTime: timeStampOfCrowdSaleStart + 12 days,  tokenPriceInPoundPences:  18})); // from 13th day to 16th day -> 10% discount
    }

    function getIcoPhaseOneThreeDayIndex(uint time) constant returns (uint){
        for (uint i = 1; i <= IcoPhaseOneArray.length; i++) {
            uint indexToEvaluate = IcoPhaseOneArray.length-i;
            if (time >= IcoPhaseOneArray[indexToEvaluate].startingTime)
                return indexToEvaluate;
        }
    }

    function getIcoPhaseOneTokenPriceInPoundPences(uint time) constant returns (uint8){
        IcoPhaseOneConfig storage todaysConfig = IcoPhaseOneArray[getIcoPhaseOneThreeDayIndex(time)];
        return todaysConfig.tokenPriceInPoundPences;
    }

    function hasIcoPhaseOneEnded (uint time) constant returns (bool){
        return time >= (IcoPhaseOneArray[IcoPhaseOneArray.length-1].startingTime + 4 days);
    }

    /**
     * Fallback function: called on ether sent.
     *
     * It calls to createSER function with msg.sender
     * as a value for holder argument
     */
    function () payable hasCrowdSaleStarted hasCrowdSaleNotYetEnded {
        // check if investment is more than 0
        if (msg.value > 0){
            mintSerTokens(msg.sender, msg.value, now);
            wallet.transfer(msg.value);
            DepositAcceptedEvent(msg.sender, msg.value);
        }
    }

    modifier hasCrowdSaleStarted() {
        require (now >= timeStampOfCrowdSaleStart);
        _;
    }

    modifier hasCrowdSaleEnded() {
        require (now >= timeStampOfCrowdSaleEnd);
        _;
    }

    modifier hasCrowdSaleNotYetEnded() {
        require (now < timeStampOfCrowdSaleEnd);
        _;
    }

    function calculateEthers(uint poundPences) constant returns (uint){
        return poundPences.mul(1 ether).div(etherPriceInPoundPences)+1;
    }

    function calculatePoundsTimesEther(uint ethersAmount) constant returns (uint){
        return ethersAmount.mul(etherPriceInPoundPences).div(100);
    }

    function setEtherPriceInPoundPences(uint32 _etherPriceInPoundPences) onlyOwner{
        etherPriceInPoundPences = _etherPriceInPoundPences;
    }

    function setInvestmentCapIcoPhaseTwoPounds(uint32 _investmentCapIcoPhaseTwoPounds) onlyOwner{
        investmentCapIcoPhaseTwoPounds = _investmentCapIcoPhaseTwoPounds;
    }

    function createSeratioStake() hasCrowdSaleEnded onlyOwner{
        uint SeratioTokens = seratioCoin.totalSupply().mul(3);
        seratioCoin.mint(wallet, SeratioTokens);
        seratioCoin.finishMinting();
    }

    function SwitchTokenTransactionsOn() hasCrowdSaleEnded onlyOwner{
        seratioCoin.start();
    }

    /**
     * Creates SER tokens.
     *
     * Runs sanity checks including safety cap
     * Then calculates current price by getPrice() function, creates SER tokens
     * Finally sends a value of transaction to the wallet
     *
     * Note: due to lack of floating point types in Solidity,
     * contract assumes that last 3 digits in tokens amount are stood after the point.
     * It means that if stored SER balance is 100000, then its real value is 100 SER
     *
     * @param sender ether sender
     * @param value amount of ethers sent
     */
    function mintSerTokens(address sender, uint value, uint timeStampOfInvestment) private {
        uint investmentCapInPounds;
        uint minimumInvestmentInPounds;
        uint8 tokenPriceInPoundPences;

        uint investmentInPoundsTimesEther = calculatePoundsTimesEther(value);
        if (hasIcoPhaseOneEnded(timeStampOfInvestment) || investmentCapPreIcoReached){
            // ICO Phase Two
            investmentCapInPounds = investmentCapIcoPhaseTwoPounds;
            minimumInvestmentInPounds = MIN_INVESTMENT_ICO_PHASE_TWO_POUNDS;
            tokenPriceInPoundPences = BASE_TOKEN_PRICE_IN_POUND_PENCES;
            require(investmentInPoundsTimesEther >= minimumInvestmentInPounds.mul(1 ether));
        }else{
            // ICO Phase One
            investmentCapInPounds = INVESTMENT_CAP_ICO_PHASE_ONE_POUNDS;
            minimumInvestmentInPounds = MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS;
            tokenPriceInPoundPences = getIcoPhaseOneTokenPriceInPoundPences(timeStampOfInvestment);
            require(investmentInPoundsTimesEther >= minimumInvestmentInPounds.mul(1 ether));

            uint totalInvestmentInPoundsTimesEther = calculatePoundsTimesEther(getTotalValue().add(value));
            uint investmentCapInPoundsTimesEther = investmentCapInPounds.mul(1 ether);
            if(totalInvestmentInPoundsTimesEther > investmentCapInPoundsTimesEther){
                // With this investment, the investment cap is reached
                investmentCapPreIcoReached = true;
                // retarget investment over phase one cap to phase two.
                uint retargetedInvestmentInPoundsTimesEther = totalInvestmentInPoundsTimesEther.sub(investmentCapInPoundsTimesEther);
                uint investmentInPoundsTimesEtherToFulfilCap = investmentInPoundsTimesEther.sub(retargetedInvestmentInPoundsTimesEther);
                // mint difference until cap is reached.
                mintHelper(sender, investmentInPoundsTimesEtherToFulfilCap, tokenPriceInPoundPences);
                // update parameters for minting retargeted investment.
                investmentInPoundsTimesEther = retargetedInvestmentInPoundsTimesEther;
                tokenPriceInPoundPences = BASE_TOKEN_PRICE_IN_POUND_PENCES;
            }
        }

        mintHelper(sender, investmentInPoundsTimesEther, tokenPriceInPoundPences);
        totalValue = totalValue.add(value);
    }

    function mintHelper(address sender, uint investmentInPoundsTimesEther, uint8 tokenPriceInPoundPences) private {
        uint tokens = investmentInPoundsTimesEther
        .mul(100).div(tokenPriceInPoundPences)
        .mul(uint(seratioCoin.DECIMAL_ZEROS()))
        .div(1 ether);

        seratioCoin.mint(sender, tokens);
    }
    function manuallyMintTokens(address beneficiary, uint value, uint timeStampOfInvestment) onlyOwner{
        mintSerTokens(beneficiary, value, timeStampOfInvestment);
    }
    function rawManuallyMintTokens(address beneficiary, uint tokens) onlyOwner{
        seratioCoin.mint(beneficiary, tokens);
    }

    /**
     * Denotes complete price structure during the sale.
     *
     * @return SER amount per 1 ETH for the current moment in time
     */
    function getPrice(uint time) constant returns (uint) {
        uint8 tokenPriceInPoundPences;
        if (hasIcoPhaseOneEnded(time)){
            tokenPriceInPoundPences = BASE_TOKEN_PRICE_IN_POUND_PENCES;
        }else{
            tokenPriceInPoundPences = getIcoPhaseOneTokenPriceInPoundPences(time);
        }
        return tokenPriceInPoundPences;
    }

    /**
     * Returns total stored SER amount.
     *
     * Contract assumes that last 5 digits of this value are behind the decimal place. i.e. 1000001 is 10.00001
     * Thus, result of this function should be divided by 100000 to get SER value
     *
     * @return result stored SER amount
     */
    function getTotalSupply() constant returns (uint) {
        return seratioCoin.totalSupply();
    }

    /**
     * Returns total value passed through the contract
     *
     * @return result total value in wei
     */
    function getTotalValue() constant returns (uint) {
        return totalValue;
    }
}