package com.example.tests;

import com.thoughtworks.selenium.*;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import static org.junit.Assert.*;
import java.util.regex.Pattern;

public class RegisterTest {
	private Selenium selenium;

	@Before
	public void setUp() throws Exception {
		selenium = new DefaultSelenium("localhost", 4444, "*chrome", "http://dev.toip.nl/");
		selenium.start();
	}

	@Test
	public void testRegister() throws Exception {
		selenium.open("/");
		selenium.click("//button[@onclick='location.href = \"/account/Register\"']");
		selenium.waitForPageToLoad("30000");
		selenium.type("name=username", "sdijk4");
		selenium.type("name=password", "sdijk4");
		selenium.type("name=passwordagain", "sdijk4");
		selenium.type("name=email", "samsam_31393@hotmail.com");
		selenium.type("name=firstname", "Sam");
		selenium.type("name=surname", "van Dijk");
		selenium.type("name=city", "Tilburg");
		selenium.type("name=zipcode", "5042GE");
		selenium.type("name=street", "Bokhamerstraat");
		selenium.type("name=streetnumber", "26");
		selenium.type("name=registrationcode", "24f38a16d81a5a4662c8efc0a1fc879aaba9b051");
		selenium.click("id=register_button");
		selenium.waitForPageToLoad("30000");
	}

	@After
	public void tearDown() throws Exception {
		selenium.stop();
	}
}
