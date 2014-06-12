package com.example.tests;

import com.thoughtworks.selenium.*;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import static org.junit.Assert.*;
import java.util.regex.Pattern;

public class FilterTest {
	private Selenium selenium;

	@Before
	public void setUp() throws Exception {
		selenium = new DefaultSelenium("localhost", 4444, "*chrome", "http://dev.toip.nl/");
		selenium.start();
	}

	@Test
	public void testFilter() throws Exception {
		selenium.open("/");
		selenium.select("id=country", "label=Algeria");
		Thread.sleep(5000);
		selenium.select("id=country", "label=");
		Thread.sleep(5000);
		selenium.select("id=projectType", "label=Minor");
		Thread.sleep(5000);
		selenium.select("id=projectType", "label=Eps");
		Thread.sleep(5000);
		selenium.select("id=projectType", "label=Graduation");
		Thread.sleep(5000);
		selenium.select("id=projectType", "label=Internship");
		Thread.sleep(5000);
		selenium.select("id=projectType", "label=");
		Thread.sleep(5000);
		selenium.select("id=locationType", "label=Education");
		Thread.sleep(5000);
		selenium.select("id=locationType", "label=Business");
		Thread.sleep(5000);
		selenium.select("id=locationType", "label=");
	}

	@After
	public void tearDown() throws Exception {
		selenium.stop();
	}
}
