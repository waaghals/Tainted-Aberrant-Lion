
public class RunTests {

	public static void main(String[] args) {
		junit.textui.TestRunner.run(LoginTest.class);
        junit.textui.TestRunner.run(RegisterTest.class);
        junit.textui.TestRunner.run(FilterTest.class);
        junit.textui.TestRunner.run(ManagementChangePasswordTest.class);
        junit.textui.TestRunner.run(ManagementEditAccountTest.class);
        junit.textui.TestRunner.run(ManagementAcceptanceDeclinedTest.class);
        junit.textui.TestRunner.run(ManagementAcceptancePendingTest.class);
        junit.textui.TestRunner.run(ManagementAcceptanceApprovedTest.class);
        junit.textui.TestRunner.run(ManagementChangePasswordResetTest.class);
	}

}
