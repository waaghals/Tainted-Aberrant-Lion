package com.example.tests;

import com.thoughtworks.selenium.*;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import static org.junit.Assert.*;
import java.util.regex.Pattern;

public class ManagementAcceptanceApproved {
	private Selenium selenium;

	@Before
	public void setUp() throws Exception {
		selenium = new DefaultSelenium("localhost", 4444, "*chrome", "http://dev.toip.nl/");
		selenium.start();
	}

	@Test
	public void testManagementAcceptanceApproved() throws Exception {
		selenium.open("/");
		selenium.click("css=button.headerbutton");
		selenium.waitForPageToLoad("30000");
		selenium.type("name=username", "hbakker");
		selenium.type("name=password", "p@ssword");
		selenium.click("id=login_button");
		selenium.waitForPageToLoad("30000");
		selenium.click("//button[@onclick='location.href = \"/Management/Home\"']");
		selenium.waitForPageToLoad("30000");
		selenium.click("link=Locations");
		selenium.waitForPageToLoad("30000");
		selenium.click("id=checkall");
		selenium.select("id=apply_to_all", "label=With Selected:");
		selenium.click("css=option[value=\"status_approved\"]");
		selenium.click("css=#with_selected_confirm > p");
		selenium.click("link=Reviews");
		selenium.waitForPageToLoad("30000");
		selenium.click("id=checkall");
		selenium.select("id=apply_to_all", "label=With Selected:");
		selenium.click("css=option[value=\"status_approved\"]");
		selenium.click("//div[@id='with_selected_confirm']/img[2]");
		selenium.click("link=Projects");
		selenium.waitForPageToLoad("30000");
		selenium.click("id=checkall");
		selenium.select("id=apply_to_all", "label=With Selected:");
		selenium.click("css=option[value=\"status_approved\"]");
		selenium.click("css=#with_selected_confirm > p");
		selenium.click("css=button.headerbutton");
		selenium.waitForPageToLoad("30000");
	}

	@After
	public void tearDown() throws Exception {
		selenium.stop();
	}
}
