/**
 * Instructions to deploy
 *
 *  1- Enter the online compiler: https://ethereum.github.io/browser-solidity/#version=soljson-v0.3.5+commit.5f97274.js&optimize=true
 *  2- Copy paste the solidity code to the left code area in the compiler page.
 *  3- Wait for the compilation to complete.
 *  4- Copy paste the first line (ABI) of the web3 deploy information below:
 *  5- Save the present file and wait for Meteor update it.
 *  7- Copy the whole web3 deploy information:
 *  8- Launch browser console and post the copied code.
 *  9- Wait for contract to be mined. Then copy the address of the contract and update it here.
 * 10- Save the present file and wait for Meteor auto update the page.
 * 11- Test sending money to the contract by issuing the following command in the browser console
 *
 * web3.eth.sendTransaction({from: web3.eth.accounts[0], to: deployedContractAddress ,value: 123000000000})
 *
 * */

// ABI
var guessnumberContract = web3.eth.contract([{"constant":false,"inputs":[{"name":"givenNumber","type":"uint8"}],"name":"setNumber","outputs":[],"type":"function"},{"constant":true,"inputs":[{"name":"givenNumber","type":"uint8"}],"name":"guessNumber","outputs":[{"name":"","type":"bool"}],"type":"function"},{"anonymous":false,"inputs":[{"indexed":false,"name":"from","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Deposit","type":"event"},{"anonymous":false,"inputs":[],"name":"SetNumber","type":"event"}]);

// Deployed Contract address
deployedContractAddress = '0x4476531d05abf031d99df4db090f95faf93479e2';

// Instance to be used by the Ðapp
GuessNumberInstance = guessnumberContract.at(deployedContractAddress);

/**
 *  To Set the number use:
 *      GuessNumberInstance.setNumber(10, {from: web3.eth.accounts[0], gas: 50000})
 *
 *  To send money to the contract use:
 *      web3.eth.sendTransaction({from: web3.eth.accounts[0], to: deployedContractAddress ,value: 123000000000})
 *
 * */