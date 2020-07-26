// get the latest block
web3.eth.filter('latest').watch(function(e, blockHash) {
    if(!e) {
        web3.eth.getBlock(blockHash, function(e, block){
            Session.set('latestBlock', block);
        });
    }
});



// Check if money arrived
// Note checking from block 0 is very unperformant!
GuessNumberInstance.Deposit({},{fromBlock: 0, toBlock: 'latest'}).watch(function(e, log) {
    if(!e) {
        var fromAddress = log.args.from;
        var depositAmount = log.args.value;
        var depositAmountString = depositAmount.toString(10);
        console.log('Money arrived! From:'+ fromAddress, depositAmountString);

        // add the transaction to our collection
        DepositsCollection.upsert('tx_'+ log.transactionHash ,{
            from: fromAddress,
            value: depositAmountString,
            blockNumber: log.blockNumber
        });
    }
});



// Check if somebody set a number
GuessNumberInstance.SetNumber({}).watch(function(e, log) {
    if(!e) {
        console.log('A new number was set on block #'+ log.blockNumber);
        alert('A new number was set on block #'+ log.blockNumber + ' Try to guess!');
    }
});
