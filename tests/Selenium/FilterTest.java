import java.util.concurrent.TimeUnit;

import junit.framework.TestCase;

import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.NoAlertPresentException;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;

public class FilterTest extends TestCase {
  private WebDriver driver;
  private String baseUrl;
  private boolean acceptNextAlert = true;
  private StringBuffer verificationErrors = new StringBuffer();

  @Before
  public void setUp() throws Exception {
    driver = new FirefoxDriver();
    baseUrl = "http://dev.toip.nl/";
    driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
  }

  @Test
  public void testFilter() throws Exception {
    driver.get(baseUrl + "/");
    new Select(driver.findElement(By.id("country"))).selectByVisibleText("Algeria");
    new Select(driver.findElement(By.id("country"))).selectByVisibleText("");
    new Select(driver.findElement(By.id("projectType"))).selectByVisibleText("Minor");
    new Select(driver.findElement(By.id("projectType"))).selectByVisibleText("Eps");
    new Select(driver.findElement(By.id("projectType"))).selectByVisibleText("Graduation");
    new Select(driver.findElement(By.id("projectType"))).selectByVisibleText("Internship");
    new Select(driver.findElement(By.id("projectType"))).selectByVisibleText("");
    new Select(driver.findElement(By.id("locationType"))).selectByVisibleText("Education");
    new Select(driver.findElement(By.id("locationType"))).selectByVisibleText("Business");
    new Select(driver.findElement(By.id("locationType"))).selectByVisibleText("");
  }

  @After
  public void tearDown() throws Exception {
    driver.quit();
    String verificationErrorString = verificationErrors.toString();
    if (!"".equals(verificationErrorString)) {
      fail(verificationErrorString);
    }
  }

  private boolean isElementPresent(By by) {
    try {
      driver.findElement(by);
      return true;
    } catch (NoSuchElementException e) {
      return false;
    }
  }

  private boolean isAlertPresent() {
    try {
      driver.switchTo().alert();
      return true;
    } catch (NoAlertPresentException e) {
      return false;
    }
  }

  private String closeAlertAndGetItsText() {
    try {
      Alert alert = driver.switchTo().alert();
      String alertText = alert.getText();
      if (acceptNextAlert) {
        alert.accept();
      } else {
        alert.dismiss();
      }
      return alertText;
    } finally {
      acceptNextAlert = true;
    }
  }
}
