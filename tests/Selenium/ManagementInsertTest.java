package com.example.tests;

import com.thoughtworks.selenium.*;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import static org.junit.Assert.*;
import java.util.regex.Pattern;

public class ManagementInsertTest {
	private Selenium selenium;

	@Before
	public void setUp() throws Exception {
		selenium = new DefaultSelenium("localhost", 4444, "*chrome", "http://dev.toip.nl/");
		selenium.start();
	}

	@Test
	public void testManagementInsert() throws Exception {
		selenium.open("/");
		selenium.click("css=button.headerbutton");
		selenium.waitForPageToLoad("30000");
		selenium.type("name=username", "hbakker");
		selenium.type("name=password", "p@ssword");
		selenium.click("id=login_button");
		selenium.waitForPageToLoad("30000");
		selenium.click("//button[@onclick='location.href = \"/Management/Home\"']");
		selenium.waitForPageToLoad("30000");
		selenium.click("link=Reviews, Projects & Locations");
		selenium.waitForPageToLoad("30000");
		selenium.click("link=My Locations");
		selenium.waitForPageToLoad("30000");
		selenium.click("css=div.fancy_button.mylocation_add > p");
		selenium.select("name=type", "label=Business");
		selenium.select("name=type", "label=Education");
		selenium.type("name=name", "Avans Hogeschool Tilburg");
		selenium.select("name=country", "label=Netherlands");
		selenium.type("name=city", "Tilburg");
		selenium.type("name=street", "Professor Cobbenhagenlaan 13");
		selenium.type("name=housenumber", "13");
		selenium.type("name=street", "Professor Cobbenhagenlaan");
		selenium.type("name=postalcode", "5037");
		selenium.type("name=email", "studentinfo@avans.nl");
		selenium.type("name=telephone", "0885257500");
		selenium.click("css=#location_action > p");
		selenium.click("link=My Projects");
		selenium.waitForPageToLoad("30000");
		selenium.click("css=div.fancy_button.myprojects_add > p");
		selenium.select("name=location", "label=Avans Hogeschool Tilburg (Tilburg)");
		selenium.select("css=form[name=\"create_project_form\"] > #register_container_tophalf > div.right_container > select[name=\"type\"]", "label=Graduation");
		selenium.select("css=form[name=\"create_project_form\"] > #register_container_tophalf > div.right_container > select[name=\"type\"]", "label=Minor");
		selenium.select("name=start_year", "label=2014");
		selenium.select("css=form[name=\"create_project_form\"] > #register_container_tophalf > div.right_container > select[name=\"type\"]", "label=Graduation");
		selenium.select("name=start_year", "label=2013");
		selenium.select("name=start_month", "label=September");
		selenium.select("name=end_year", "label=2014");
		selenium.select("name=end_month", "label=June");
		selenium.click("css=#projects_action > p");
		selenium.click("link=My Reviews");
		selenium.waitForPageToLoad("30000");
		selenium.click("css=div.fancy_button.myreviews_add > p");
		selenium.select("name=project", "label=Avans Hogeschool Tilburg (Tilburg) - Graduation");
		selenium.select("name=assignment_score", "label=3");
		selenium.select("name=guidance_score", "label=4");
		selenium.select("name=accomodation_score", "label=5");
		selenium.select("name=overall_score", "label=4");
		selenium.type("name=review", "Het was een super ervaring om mijn afstuderen hier te doen.");
		selenium.click("css=#review_action > p");
		selenium.waitForPageToLoad("30000");
		selenium.click("css=button.headerbutton");
		selenium.waitForPageToLoad("30000");
	}

	@After
	public void tearDown() throws Exception {
		selenium.stop();
	}
}
