import assertRevert from '../../helpers/assertRevert';
const MintableBurnableERC827TokenMock = artifacts.require('MintableBurnableERC827TokenMock');

contract('Mintable Burnable ERC827 Token - Mintable Burnable Functionality', function ([owner, anotherAccount]) {
  const initialBalance = 1000;
  beforeEach(async function () {
    this.token = await MintableBurnableERC827TokenMock.new(owner, initialBalance, {from: owner});
  });

  /**
   * Minting section
   */
  describe('minting finished', function () {
    describe('when the token is not finished', function () {
      it('returns false', async function () {
        const mintingFinished = await this.token.mintingFinished();
        assert.equal(mintingFinished, false);
      });
    });

    describe('when the token is finished', function () {
      beforeEach(async function () {
        await this.token.finishMinting({ from: owner });
      });

      it('returns true', async function () {
        const mintingFinished = await this.token.mintingFinished.call();
        assert.equal(mintingFinished, true);
      });
    });
  });

  describe('finish minting', function () {
    describe('when the sender is the token owner', function () {
      const from = owner;

      describe('when the token was not finished', function () {
        it('finishes token minting', async function () {
          await this.token.finishMinting({ from });

          const mintingFinished = await this.token.mintingFinished();
          assert.equal(mintingFinished, true);
        });

        it('emits a mint finished event', async function () {
          const { logs } = await this.token.finishMinting({ from });

          assert.equal(logs.length, 1);
          assert.equal(logs[0].event, 'MintFinished');
        });
      });

      describe('when the token was already finished', function () {
        beforeEach(async function () {
          await this.token.finishMinting({ from });
        });

        it('reverts', async function () {
          await assertRevert(this.token.finishMinting({ from }));
        });
      });
    });

    describe('when the sender is not the token owner', function () {
      const from = anotherAccount;

      describe('when the token was not finished', function () {
        it('reverts', async function () {
          await assertRevert(this.token.finishMinting({ from }));
        });
      });

      describe('when the token was already finished', function () {
        beforeEach(async function () {
          await this.token.finishMinting({ from: owner });
        });

        it('reverts', async function () {
          await assertRevert(this.token.finishMinting({ from }));
        });
      });
    });
  });

  describe('mint', function () {
    const amount = 100;

    describe('when the sender is the token owner', function () {
      const from = owner;

      describe('when the token was not finished', function () {
        it('mints the requested amount', async function () {
          await this.token.mint(owner, amount, { from });

          const balance = await this.token.balanceOf(owner);
          assert.equal(balance, initialBalance + amount);
        });

        it('emits a mint finished event', async function () {
          const { logs } = await this.token.mint(owner, amount, { from });

          assert.equal(logs.length, 2);
          assert.equal(logs[0].event, 'Mint');
          assert.equal(logs[0].args.to, owner);
          assert.equal(logs[0].args.amount, amount);
          assert.equal(logs[1].event, 'Transfer');
        });
      });

      describe('when the token minting is finished', function () {
        beforeEach(async function () {
          await this.token.finishMinting({ from });
        });

        it('reverts', async function () {
          await assertRevert(this.token.mint(owner, amount, { from }));
        });
      });
    });

    describe('when the sender is not the token owner', function () {
      const from = anotherAccount;

      describe('when the token was not finished', function () {
        it('reverts', async function () {
          await assertRevert(this.token.mint(owner, amount, { from }));
        });
      });

      describe('when the token was already finished', function () {
        beforeEach(async function () {
          await this.token.finishMinting({ from: owner });
        });

        it('reverts', async function () {
          await assertRevert(this.token.mint(owner, amount, { from }));
        });
      });
    });
  });

  /**
   * Burning section
   */

  describe('burn', function () {
    const from = owner;

    describe('when the given amount is not greater than balance of the sender', function () {
      const amount = 100;

      it('burns the requested amount', async function () {
        await this.token.burn(amount, { from });

        const balance = await this.token.balanceOf(from);
        assert.equal(balance, initialBalance - amount);
      });

      it('emits a burn event', async function () {
        const { logs } = await this.token.burn(amount, { from });
        const ZERO_ADDRESS = '0x0000000000000000000000000000000000000000';
        console.log(logs.length);
        assert.equal(logs.length, 2);
        assert.equal(logs[0].event, 'Burn');
        assert.equal(logs[0].args.burner, owner);
        assert.equal(logs[0].args.value, amount);

        assert.equal(logs[1].event, 'Transfer');
        assert.equal(logs[1].args.from, owner);
        assert.equal(logs[1].args.to, ZERO_ADDRESS);
        assert.equal(logs[1].args.value, amount);
      });
    });

    describe('when the given amount is greater than the balance of the sender', function () {
      const amount = 1001;

      it('reverts', async function () {
        await assertRevert(this.token.burn(amount, { from }));
      });
    });
  });

  /**
   * ERC 827 section
   */

});
