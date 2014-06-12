package com.example.tests;

import com.thoughtworks.selenium.*;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import static org.junit.Assert.*;
import java.util.regex.Pattern;

public class ManagementEditAccountTest {
	private Selenium selenium;

	@Before
	public void setUp() throws Exception {
		selenium = new DefaultSelenium("localhost", 4444, "*chrome", "http://dev.toip.nl/");
		selenium.start();
	}

	@Test
	public void testManagementEditAccount() throws Exception {
		selenium.open("/");
		selenium.click("css=button.headerbutton");
		selenium.waitForPageToLoad("30000");
		selenium.click("name=username");
		selenium.type("name=username", "hbakker");
		selenium.type("name=password", "p@ssword");
		selenium.waitForPageToLoad("30000");
		selenium.click("//button[@onclick='location.href = \"/Management/Home\"']");
		selenium.waitForPageToLoad("30000");
		selenium.click("link=My Account");
		selenium.waitForPageToLoad("30000");
		selenium.type("name=addition", "a");
		selenium.waitForPageToLoad("30000");
		selenium.click("id=management_save");
		selenium.click("css=button.headerbutton");
		selenium.waitForPageToLoad("30000");
	}

	@After
	public void tearDown() throws Exception {
		selenium.stop();
	}
}
