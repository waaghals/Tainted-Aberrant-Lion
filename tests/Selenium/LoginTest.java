package com.example.tests;

import com.thoughtworks.selenium.*;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import static org.junit.Assert.*;
import java.util.regex.Pattern;

public class LoginTest {
	private Selenium selenium;

	@Before
	public void setUp() throws Exception {
		selenium = new DefaultSelenium("localhost", 4444, "*chrome", "http://dev.toip.nl/");
		selenium.start();
	}

	@Test
	public void testLogin() throws Exception {
		selenium.open("/");
		selenium.click("css=button.headerbutton");
		selenium.waitForPageToLoad("30000");
		selenium.type("name=username", "hbakker");
		selenium.type("name=password", "password");
		selenium.click("id=login_button");
		selenium.waitForPageToLoad("30000");
		selenium.clickAt("css=button.headerbutton", "");
		selenium.waitForPageToLoad("30000");
	}

	@After
	public void tearDown() throws Exception {
		selenium.stop();
	}
}
