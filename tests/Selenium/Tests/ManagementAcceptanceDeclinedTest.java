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

public class ManagementAcceptanceDeclinedTest extends TestCase {
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
  public void testManagementAcceptanceDeclined() throws Exception {
    driver.get(baseUrl + "/");
    driver.findElement(By.cssSelector("button.headerbutton")).click();
    driver.findElement(By.name("username")).clear();
    driver.findElement(By.name("username")).sendKeys("hbakker");
    driver.findElement(By.name("password")).clear();
    driver.findElement(By.name("password")).sendKeys("p@ssword");
    driver.findElement(By.id("login_button")).click();
    driver.findElement(By.xpath("//button[@onclick='location.href = \"/Management/Home\"']")).click();
    driver.findElement(By.linkText("Locations")).click();
    driver.findElement(By.id("checkall")).click();
    new Select(driver.findElement(By.id("apply_to_all"))).selectByVisibleText("With Selected:");
    driver.findElement(By.cssSelector("option[value=\"status_declined\"]")).click();
    driver.findElement(By.cssSelector("#with_selected_confirm > p")).click();
    driver.findElement(By.linkText("Reviews")).click();
    driver.findElement(By.id("checkall")).click();
    new Select(driver.findElement(By.id("apply_to_all"))).selectByVisibleText("With Selected:");
    driver.findElement(By.cssSelector("option[value=\"status_declined\"]")).click();
    driver.findElement(By.xpath("//div[@id='with_selected_confirm']/img[2]")).click();
    driver.findElement(By.linkText("Projects")).click();
    driver.findElement(By.id("checkall")).click();
    new Select(driver.findElement(By.id("apply_to_all"))).selectByVisibleText("With Selected:");
    driver.findElement(By.cssSelector("option[value=\"status_declined\"]")).click();
    driver.findElement(By.cssSelector("#with_selected_confirm > p")).click();
    driver.findElement(By.xpath("//button[@onclick='location.href = \"/Account/Logout\"']")).click();
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
