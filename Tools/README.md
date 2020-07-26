#Private Chain

## Genesis block

The idea is to create a genesis block utilizing the same strategy from EF according to the [announcement blog post on how to generate your file](https://blog.ethereum.org/2015/07/27/final-steps/).

After running the following code according to the announcement but changing block hash to the [hash of #1028223](https://live.ether.camp/block/1028223):

```mk_genesis_block.py --extradata hash_for_#1028223_goes_here > genesis_block.json```

It successfully generated the genesis_block.json after a while executing.

## Private Chain Creation
To create the private chain first make sure the ethereum_private folder is empty.
Then run the following code to create a new account:

```python CreateNewAccount.py```

That will add the keystore folder inside ethereum_private folder.
To create the private chain utilizing the genesis_block.json previously generated, run the following code:

```python InitPrivateTestnetChain.py```

This will populate the private testnet contents inside ethereum_private folder.

But It was giving the following error:
   
``` fatal: failed to write genesis block: invalid character 'ÿ' looking for beginning of value ```
   
The workaround was to utilize the Zerogox faucet as a [genesis Block template](https://zerogox.com/ethereum/wei_faucet) instead.

## Running the node

To run geth node and start mining simply run:

```python RunEthereumNode.py```

After a while mining balance can be acessed with the following command in the console:

```web3.fromWei(eth.getBalance(eth.coinbase), "ether")```
