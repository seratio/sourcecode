const Microshares = artifacts.require('Microshares');

contract('Microshares', accounts => {
  let microshares;

  console.log('Estimated gas for contract is: ' + web3.eth.estimateGas({ data: Microshares.bytecode }));

  beforeEach(async function () {
    microshares = await Microshares.new({ from: accounts[0] });
  });



  describe('Test deployed', async function () {
    // let readName = await microshares.name.call();
    assert(true);
  });
});
