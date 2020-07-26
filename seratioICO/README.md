#Seratio ICO Genesis

## Getting started:

### Preparation of project folder:
```
git clone https://git.assembla.com/blockchain-un-lab.ico.git
cd blockchain-un-lab.ico.git
npm install
```

### Test

#### Compilation:
```
truffle compile
```
_____

#### Ethereum Client start
You should then start an Ethereum client.
For the test purpose let's use testrpc with the following command:
```
testrpc --port 8545 --account="0x2bdd21761a483f71054e14f5b827213567971c676928d9a1808cbfa4b7501200,1000000000000000000000000"      --account="0x2bdd21761a483f71054e14f5b827213567971c676928d9a1808cbfa4b7501201,1000000000000000000000000"      --account="0x2bdd21761a483f71054e14f5b827213567971c676928d9a1808cbfa4b7501202,1000000000000000000000000"

```
____

#### Deployment to the selected Ethereum network
So that you can deploy to the testrpc with the following command:
```
truffle migrate
```
____
#### Test procedure
And finally test with the following command:
```
truffle test
```