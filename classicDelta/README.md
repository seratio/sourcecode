# Classic Delta Smart Contracts

Introduction of Classic Delta Smart Contracts

## Introduction
### Vision: 
 
### Mission:

### Strategy: 
 
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
truffle console --network live
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
truffle migrate --reset --network live
```