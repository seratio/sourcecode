'user strict';
import expectThrow from './helpers/expectThrow';

var SeratioCoin = artifacts.require('../contracts/SeratioCoin.sol');

let sendEthers = function(sender, receiver, value){
    web3.eth.sendTransaction({
        from:sender,
        to:receiver,
        gas: 130000,
        value: value
    });
};

function sleep(ms = 0) {
    return new Promise(r => setTimeout(r, ms));
}

const assertJump = require('./helpers/assertJump');
var SeratioICOMock = artifacts.require('./helpers/SeratioICOMock.sol');

contract('SeratioICO', function (accounts) {
    let currentTimeStamp = + new Date()/1000 | 0;
    // let icoMock;

    // beforeEach(async function() {
    //     icoMock = await SeratioICOMock.new(1497754976, accounts[0], accounts[9], 100);
    // });
    // it("Should match ICO parameters accordingly", async function() {
    //     icoMock = await SeratioICOMock.new(1497754976, accounts[0], accounts[9], 100);
    //     let oneDay = Number(await icoMock.oneDay());
    //     let timeStampOfCrowdSaleStart = Number(await icoMock.timeStampOfCrowdSaleStart());
    //     let timeStampOfCrowdSaleEnd = Number(await icoMock.timeStampOfCrowdSaleEnd());
    //     for (var T = timeStampOfCrowdSaleStart, i=1; T < timeStampOfCrowdSaleEnd; T += oneDay, i++) {
    //         let priceThatDay = Number(await icoMock.getPrice(T));
    //         console.log('Timestamp:', T, 'Day:', i, 'Price:', priceThatDay)
    //     }
    // });
    it("Should receive right amount of tokens back from investment", async function() {
        let owner = accounts[0];
        let deposit = accounts[1];
        let icoMock = await SeratioICOMock.new(currentTimeStamp, deposit);
        let minInvestmentIcoPhaseOnePounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseOnePounds/etherPriceInPounds;

        let depositBalanceBefore = web3.eth.getBalance(deposit).toNumber();

        let seratioCoin = SeratioCoin.at(await icoMock.seratioCoin());
        let tokenBalanceBefore = Number(await seratioCoin.balanceOf(accounts[0]));
        //console.log('Token balance before:\t', tokenBalanceBefore);

        //console.log('Balance before:\t', depositBalanceBefore);
        let investmentInWei = Number(web3.toWei(minimumInvestmentInEthers, 'ether'));
        //console.log('Investment in wei:\t', investmentInWei);
        sendEthers(owner, icoMock.address, investmentInWei);

        let depositBalanceAfter = web3.eth.getBalance(deposit).toNumber();
        let tokenBalanceAfter = Number(await seratioCoin.balanceOf(accounts[0]));
        //console.log('Balance after:\t', depositBalanceAfter);
        assert.equal(depositBalanceAfter, depositBalanceBefore+investmentInWei);
        let seratioCoinDecimalZeros = Number(await seratioCoin.DECIMAL_ZEROS());
        assert.equal(tokenBalanceAfter, tokenBalanceBefore + 50000*seratioCoinDecimalZeros);
    });
    it("Should be able to update ether price but still receive same amount of tokens per pound", async function() {
        let owner = accounts[0];
        let deposit = accounts[2];
        let icoMock = await SeratioICOMock.new(currentTimeStamp, deposit);
        let minInvestmentIcoPhaseOnePounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseOnePounds/etherPriceInPounds;

        let depositBalanceBefore = web3.eth.getBalance(deposit).toNumber();

        let seratioCoin = SeratioCoin.at(await icoMock.seratioCoin());
        let tokenBalanceBefore = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Token balance before:\t', tokenBalanceBefore);

        // console.log('Ether Balance before:\t', depositBalanceBefore);
        let investmentInWei = Number(web3.toWei(minimumInvestmentInEthers, 'ether'));
        // console.log('Investment in wei:\t', investmentInWei);
        sendEthers(owner, icoMock.address, investmentInWei);

        let depositBalanceAfter = web3.eth.getBalance(deposit).toNumber();
        // console.log('Ether balance after:\t', depositBalanceAfter);
        let tokenBalanceAfter = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Token Balance after:\t', tokenBalanceAfter);
        assert.equal(depositBalanceAfter, depositBalanceBefore+investmentInWei);
        let seratioCoinDecimalZeros = Number(await seratioCoin.DECIMAL_ZEROS());
        assert.equal(tokenBalanceAfter, tokenBalanceBefore + 50000*seratioCoinDecimalZeros);

        /**
         * Second round of investment just after ether price update
         */
        // console.log('\r\n');
        await icoMock.setEtherPriceInPoundPences(60000);
        let etherPriceInPoundsB = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthersB = minInvestmentIcoPhaseOnePounds/etherPriceInPoundsB;
        assert(minimumInvestmentInEthers, minimumInvestmentInEthersB/2);

        let depositBalanceBeforeB = web3.eth.getBalance(deposit).toNumber();
        let tokenBalanceBeforeB = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Token balance before:\t', tokenBalanceBeforeB);

        // console.log('Ether Balance before:\t', depositBalanceBeforeB);
        let investmentInWeiB = Number(web3.toWei(minimumInvestmentInEthersB, 'ether'));
        // console.log('Investment in wei:\t', investmentInWeiB);
        sendEthers(owner, icoMock.address, investmentInWeiB);

        let depositBalanceAfterB = web3.eth.getBalance(deposit).toNumber();
        // console.log('Ether balance after:\t', depositBalanceAfterB);
        let tokenBalanceAfterB = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Token balance after:\t', tokenBalanceAfterB);
        assert.equal(depositBalanceAfterB, depositBalanceBeforeB+investmentInWeiB);
        assert.equal(tokenBalanceAfterB, tokenBalanceBeforeB + 50000*seratioCoinDecimalZeros);
    });

    it("Should receive right amount of manually minted tokens back from investment", async function() {
        let owner = accounts[0];
        let deposit = accounts[1];
        let beneficiary = accounts[2];
        let icoMock = await SeratioICOMock.new(currentTimeStamp, deposit);
        let valueToInvestPounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS())+1000;
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        // console.log('Manual investment of:\t', valueToInvestPounds, ' pounds');

        let seratioCoin = SeratioCoin.at(await icoMock.seratioCoin());
        let tokenBalanceBefore = Number(await seratioCoin.balanceOf(beneficiary));
        // console.log('Token balance before:\t', tokenBalanceBefore);
        let investmentInWei = Number(web3.toWei(valueToInvestPounds/etherPriceInPounds, 'ether'));
        // console.log('Investment in wei:\t', investmentInWei);
        await icoMock.manuallyMintTokens(beneficiary, investmentInWei, currentTimeStamp);

        let tokenBalanceAfter = Number(await seratioCoin.balanceOf(beneficiary));
        // console.log('Token balance after:\t', tokenBalanceAfter);
        let seratioCoinDecimalZeros = Number(await seratioCoin.DECIMAL_ZEROS());
        assert.equal(tokenBalanceAfter, tokenBalanceBefore + 60000*seratioCoinDecimalZeros);
    });

    it("Should not allow ICO investments before the ICO starts", async function() {
        let oneDay = 24 * 60 * 60;
        let owner = accounts[0];
        let deposit = accounts[1];
        let icoMock = await SeratioICOMock.new(currentTimeStamp + oneDay/2, deposit);
        let minInvestmentIcoPhaseOnePounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseOnePounds/etherPriceInPounds;

        try {
            sendEthers(owner, icoMock.address, web3.toWei(minimumInvestmentInEthers, 'ether'))
        } catch (error) {
            return assertJump(error);
        }
        assert.fail('should have thrown before');
    });
    it("Should not allow ICO investments after the ICO ends", async function() {
        let oneDay = 24 * 60 * 60;
        let owner = accounts[0];
        let deposit = accounts[1];
        let icoMock = await SeratioICOMock.new(currentTimeStamp-47*oneDay, deposit);
        let minInvestmentIcoPhaseOnePounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseOnePounds/etherPriceInPounds;

        try {
            sendEthers(owner, icoMock.address, web3.toWei(minimumInvestmentInEthers, 'ether'))
        } catch (error) {
            return assertJump(error);
        }
        assert.fail('should have thrown before');
    });
    it("Should allow ICO investments to happen on first minute of the regular ICO and check amount of tokens received back", async function() {
        let oneDay = 24 * 60 * 60;
        let owner = accounts[0];
        let deposit = accounts[1];
        let icoMock = await SeratioICOMock.new(currentTimeStamp-16*oneDay, deposit);
        let minInvestmentIcoPhaseOnePounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseOnePounds/etherPriceInPounds;

        let depositBalanceBefore = web3.eth.getBalance(deposit).toNumber();

        let seratioCoin = SeratioCoin.at(await icoMock.seratioCoin());
        let tokenBalanceBefore = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Token balance before:\t', tokenBalanceBefore);

        // console.log('Balance before:\t', balanceBefore);
        let investmentInWei = Number(web3.toWei(minimumInvestmentInEthers, 'ether'));
        // console.log('Investment in wei:\t', investmentInWei);
        sendEthers(owner, icoMock.address, investmentInWei);

        let depositBalanceAfter = web3.eth.getBalance(deposit).toNumber();
        let tokenBalanceAfter = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Balance after:\t', balanceAfter);
        assert.equal(depositBalanceAfter, depositBalanceBefore+investmentInWei);
        let seratioCoinDecimalZeros = Number(await seratioCoin.DECIMAL_ZEROS());
        assert.equal(tokenBalanceAfter, tokenBalanceBefore + 25000*seratioCoinDecimalZeros);
    });
    it("Should allow ICO investments to happen on last minute of the ICO and check amount of tokens received back", async function() {
        let oneDay = 24 * 60 * 60;
        let owner = accounts[0];
        let deposit = accounts[1];
        let icoMock = await SeratioICOMock.new(currentTimeStamp-47*oneDay+60, deposit);
        let minInvestmentIcoPhaseOnePounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseOnePounds/etherPriceInPounds;

        let depositBalanceBefore = web3.eth.getBalance(deposit).toNumber();

        let seratioCoin = SeratioCoin.at(await icoMock.seratioCoin());
        let tokenBalanceBefore = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Token balance before:\t', tokenBalanceBefore);

        // console.log('Balance before:\t', balanceBefore);
        let investmentInWei = Number(web3.toWei(minimumInvestmentInEthers, 'ether'));
        // console.log('Investment in wei:\t', investmentInWei);
        sendEthers(owner, icoMock.address, investmentInWei);

        let depositBalanceAfter = web3.eth.getBalance(deposit).toNumber();
        let tokenBalanceAfter = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Balance after:\t', balanceAfter);
        assert.equal(depositBalanceAfter, depositBalanceBefore+investmentInWei);
        let seratioCoinDecimalZeros = Number(await seratioCoin.DECIMAL_ZEROS());
        assert.equal(tokenBalanceAfter, tokenBalanceBefore + 25000*seratioCoinDecimalZeros);
    });
    it("Should allow ICO investments to happen on last minute of the pre ICO and check amount of tokens received back", async function() {
        let oneDay = 24 * 60 * 60;
        let owner = accounts[0];
        let deposit = accounts[1];
        let icoMock = await SeratioICOMock.new(currentTimeStamp-16*oneDay+60, deposit);
        //let minInvestmentIcoPhaseOnePounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let investmentInEthers = 18000/etherPriceInPounds;

        let depositBalanceBefore = web3.eth.getBalance(deposit).toNumber();

        let seratioCoin = SeratioCoin.at(await icoMock.seratioCoin());
        let tokenBalanceBefore = Number(await seratioCoin.balanceOf(accounts[0]));
       // console.log('Token balance before:\t', tokenBalanceBefore);

        // console.log('Balance before:\t', depositBalanceBefore);
        let investmentInWei = Number(web3.toWei(investmentInEthers, 'ether'));
        // console.log('Investment in wei:\t', investmentInWei);
        sendEthers(owner, icoMock.address, investmentInWei);

        let depositBalanceAfter = web3.eth.getBalance(deposit).toNumber();
        let tokenBalanceAfter = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Balance after:\t', depositBalanceAfter);
        // assert.equal(depositBalanceAfter, depositBalanceBefore+investmentInWei);
        // console.log('Token balance after:\t', tokenBalanceAfter);
        let seratioCoinDecimalZeros = Number(await seratioCoin.DECIMAL_ZEROS());
        assert.equal(tokenBalanceAfter, tokenBalanceBefore + 100000*seratioCoinDecimalZeros);
    });
    it("Should respect minimum investment for phase one", async function() {
        let owner = accounts[0];
        let deposit = accounts[1];
        let icoMock = await SeratioICOMock.new(currentTimeStamp, deposit);
        let minInvestmentIcoPhaseOnePounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseOnePounds/etherPriceInPounds;

        try {
            sendEthers(owner, icoMock.address, web3.toWei(minimumInvestmentInEthers, 'ether')-2000)
        } catch (error) {
            return assertJump(error);
        }
        assert.fail('should have thrown before');
    });
    it("Should respect minimum investment for phase two", async function() {
        let oneDay = 24 * 60 * 60;
        let owner = accounts[0];
        let deposit = accounts[1];
        let icoMock = await SeratioICOMock.new(currentTimeStamp - 15*oneDay, deposit);
        let minInvestmentIcoPhaseTwoPounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_TWO_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseTwoPounds/etherPriceInPounds;

        try {
            sendEthers(owner, icoMock.address, web3.toWei(minimumInvestmentInEthers, 'ether')-2000)
        } catch (error) {
            return assertJump(error);
        }
        assert.fail('should have thrown before');
    });
    it("Should respect investment cap for phase one", async function() {
        let owner = accounts[0];
        let deposit = accounts[2];
        let icoMock = await SeratioICOMock.new(currentTimeStamp, deposit);
        let investmentCapIcoPounds = Number(await icoMock.INVESTMENT_CAP_ICO_PHASE_ONE_POUNDS());
        let minInvestmentIcoPhaseOnePounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_ONE_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseOnePounds/etherPriceInPounds;
        let investmentCapIcoInEthers = investmentCapIcoPounds/etherPriceInPounds;

        let depositBalanceBefore = web3.eth.getBalance(deposit).toNumber();

        let seratioCoin = SeratioCoin.at(await icoMock.seratioCoin());
        let tokenBalanceBefore = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Token balance before:\t', tokenBalanceBefore);

        // console.log('Ether Balance before:\t', depositBalanceBefore);
        // Leave room for 5000 pounds in ICO phase one
        let investmentInWei = Number(web3.toWei(investmentCapIcoInEthers-6000/etherPriceInPounds, 'ether'));
        // console.log('Investment in wei:\t', investmentInWei);
        sendEthers(owner, icoMock.address, investmentInWei);
        /**
         * Second round of investment to reach ico cap
         */
            // console.log('\r\n');
        let depositBalanceBeforeB = web3.eth.getBalance(deposit).toNumber();
        let tokenBalanceBeforeB = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Token balance before:\t', tokenBalanceBeforeB);

        // console.log('Ether Balance before:\t', depositBalanceBeforeB);
        let investmentInWeiB = Number(web3.toWei(12000/etherPriceInPounds, 'ether'));
        // console.log('Investment in wei:\t', investmentInWeiB);
        sendEthers(owner, icoMock.address, investmentInWeiB);

        let depositBalanceAfterB = web3.eth.getBalance(deposit).toNumber();
        // console.log('Ether balance after:\t', depositBalanceAfterB);
        let tokenBalanceAfterB = Number(await seratioCoin.balanceOf(accounts[0]));
        // console.log('Token balance after:\t', tokenBalanceAfterB);
        // assert.equal(depositBalanceAfterB, depositBalanceBeforeB+investmentInWeiB);
        let seratioCoinDecimalZeros = Number(await seratioCoin.DECIMAL_ZEROS());
        assert.equal(tokenBalanceAfterB, tokenBalanceBeforeB + 90000*seratioCoinDecimalZeros-1);
    });
    it("Should create right amount of tokens for Seratio", async function() {
        let oneDay = 24 * 60 * 60;
        let owner = accounts[0];
        let deposit = accounts[1];
        let secondsBeforeIcoEnds = 30;
        let icoMock = await SeratioICOMock.new(currentTimeStamp-47*oneDay+secondsBeforeIcoEnds, deposit);
        let minInvestmentIcoPhaseTwoPounds = Number(await icoMock.MIN_INVESTMENT_ICO_PHASE_TWO_POUNDS());
        let etherPriceInPounds = Number(await icoMock.etherPriceInPoundPences())/100;
        let minimumInvestmentInEthers = minInvestmentIcoPhaseTwoPounds/etherPriceInPounds;

        try {
            sendEthers(owner, icoMock.address, web3.toWei(minimumInvestmentInEthers, 'ether'))
        } catch (error) {
            assert.fail('Not enough time provided for investment to happen before ICO ends');
        }

        let totalSupplyBefore = Number(await icoMock.getTotalSupply());
        // console.log('Total supply before:\t', totalSupplyBefore);
        let totalValueBefore = Number(await icoMock.getTotalValue());
        // console.log('Total value before:\t', totalValueBefore);
        await sleep(secondsBeforeIcoEnds*1000); // await ICO end.
        await icoMock.createSeratioStake();
        let totalSupplyAfter = Number(await icoMock.getTotalSupply());
        // console.log('Total supply after:\t', totalSupplyAfter);
        let totalValueAfter = Number(await icoMock.getTotalValue());
        // console.log('Total value after:\t', totalValueAfter);
        assert.equal(totalSupplyAfter, totalSupplyBefore*4);
    });
});