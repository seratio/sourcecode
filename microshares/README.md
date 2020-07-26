# Microshares

Introduction of Microshares according to [whitepaper](https://cpb-eu-west-2-juc1ugur1qwqqqo4.stackpathdns.com/mypad.northampton.ac.uk/dist/7/7932/files/2017/03/Seratio-Microshare-Whitepaper-7-0-29-Oct-2017-v-1.17-2k14ktn.pdf)

## Introduction
### Vision: 
CCEG predicts a world where the intangible values are recognised and transacted. Where the total transaction value rather than simple financial value is understood – where communities and the environment are flourishing. 
### Microshares:
Microshares are the articulation of the non-financial value of an entity, process or product. Ownership implies alignment, giving a voice and a vote to the owner.  
### Mission:
The Microshare will be a complimentary element in a suite of Seratio cryptocurrency solutions which together provide the vehicle whereby anyone, anywhere can 

- Transact social value
- Transact impact value
- Transact values

### Strategy: 
Microshare Tokens will be issued: 
- As part of the SER Token ICO as a reward for fundraising
- As part of Alt-Coin ICO launch for vibrant aligned communities, women’s coin, eduCoin etc.
- Ongoing to people/organisations/projects/processes/products when they positively contribute to social impact
- As part of product sourcing and rating of supply chains - provenance
 
###Reward Network: 
- To provide a reward network through discounts at retail outlets, online and others 

###Other Benefits 
- To provide a voice and community
- To provide a vote mechanism to influence others
- To become a source of independent value
- To become tradable in their own right non-financial markets and ultimately in the financial markets 

## Getting Started
```
npm install
```

### Private testnet
To start a private testnet, make sure [ganache-cli](https://github.com/trufflesuite/ganache-cli) is properly installed.
If you haven't done so before, install it by:
```bash
npm install -g ganache-cli
```

#### Starting private testnet
```bash
npm run ganache
```

### Run test
```bash
truffle test --network ganache
```

### Console
```bash
truffle console --network mainnet
```

#### Test network
```javascript
web3.eth.getBlockNumber((e, block) => { console.log(block)})
```

#### Check HD wallet address
```javascript
web3.eth._requestManager.provider.addresses[0]
```

## Migration

### To test network
Migrating the code to Ganache test network can be done only after starting ganache-CLI by:
```bash
npm run ganache
```

Migration command to just started ganache network:
```bash
truffle migrate --reset --network ganache
```

### To main network - costs involved
Make sure you have specified a .env file according to [.env.example](https://github.com/ClassicDelta/Smart-Contracts/blob/master/.env.example) provided.
Then run the following command:
```bash
truffle migrate --reset --network mainnet
```