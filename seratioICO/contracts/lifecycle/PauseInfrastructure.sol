pragma solidity ^0.4.8;

import '../../node_modules/zeppelin-solidity/contracts/ownership/Ownable.sol';

contract PauseInfrastructure is Ownable {
    event triggerUnpauseEvent();
    event triggerPauseEvent();

    bool public paused;

    /**
     * constructor assigns initial paused state
     * @param _paused selects the initial pause state.
     */
    function PauseInfrastructure(bool _paused){
        paused = _paused;
    }

    /**
     * @dev modifier to allow actions only when the contract IS paused
     */
    modifier whenNotPaused() {
        if (paused) revert();
        _;
    }

    /**
     * @dev modifier to allow actions only when the contract IS NOT paused
     */
    modifier whenPaused {
        require (paused);
        _;
    }
}
