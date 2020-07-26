namespace Seratio.Blockchain.Sandbox.Core.Entities.Common
{
    public class AppUser
    {
        public int ID { get; set; }

        public string NickName { get; set; }

        public string Email { get; set; }

        public string Gender { get; set; }

        public string Phone { get; set; }

        //public string WalletAddress { get; set; }

        public bool IsSearchable { get; set; }

        public bool IsSuperAdmin { get; set; }

        public bool IsEmailverified { get; set; }

        public bool CanAccessRetailEnd { get; set; }

        public bool CanAccessRewardingBody { get; set; }

        public bool CanAccessProvinance { get; set; }

        //public string SaftyQuestion { get; set; }

        //public byte[] SaftyAnswer { get; set; }

        public bool ShouldAllowSignInWithQR { get; set; }

        public int SessionID { get; set; }

        public bool AllowEmailNotifications { get; set; }

        public bool RequiresTwoFactorAuthentication { get; set; }

        public bool PendingTwoFactorAuthentication { get; set; }

        public string UsernameUsed { get; set; }

        public bool PendingWalletCreation { get; set; }

        public bool IsBlockedWallet { get; set; }

    }
}