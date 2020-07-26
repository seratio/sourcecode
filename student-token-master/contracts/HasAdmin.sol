pragma solidity ^0.4.0;

import "openzeppelin-solidity/contracts/ownership/Ownable.sol";

contract HasAdmin is Ownable{
    address public admin;

    event AdministrationRoleTransferred(
        address indexed previousAdmin,
        address indexed newAdmin
    );

    /**
     * @dev Throws if called by any account other than the admin.
     */
    modifier onlyAdmin() {
        require(msg.sender == admin);
        _;
    }

    constructor(address _admin) public {
        require(_admin != address(0));
        admin = _admin;
    }

    /**
     * @dev Allows the current admin to transfer administration role of the contract to a newAdmin.
     * @param _newAdmin The address to transfer ownership to.
     */
    function transferAdministrationRole(address _newAdmin) public onlyOwner {
        internalTransferAdministrationRole(_newAdmin);
    }

    /**
     * @dev Transfers control of the contract to a newAdmin.
     * @param _newAdmin The address to transfer administration role to.
     */
    function internalTransferAdministrationRole(address _newAdmin) internal {
        require(_newAdmin != address(0));
        emit AdministrationRoleTransferred(admin, _newAdmin);
        admin = _newAdmin;
    }
}
