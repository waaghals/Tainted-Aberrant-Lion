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
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.interactions.Actions;

public class ManagementChangePasswordResetTest extends TestCase {
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
  public void testManagementChangePassword() throws Exception {
    driver.get(baseUrl + "/");
    driver.findElement(By.cssSelector("button.headerbutton")).click();
    driver.findElement(By.name("username")).click();
    driver.findElement(By.name("username")).clear();
    driver.findElement(By.name("username")).sendKeys("hbakker");
    driver.findElement(By.name("password")).clear();
    driver.findElement(By.name("password")).sendKeys("p@ssword");
    driver.findElement(By.id("login_button")).click();
    driver.findElement(By.xpath("//button[@onclick='location.href = \"/Management/Home\"']")).click();
    driver.findElement(By.linkText("Change Password")).click();
    driver.findElement(By.name("old_password")).clear();
    driver.findElement(By.name("old_password")).sendKeys("p@ssword");
    driver.findElement(By.name("new_password")).clear();
    driver.findElement(By.name("new_password")).sendKeys("password");
    driver.findElement(By.name("rep_new_password")).clear();
    driver.findElement(By.name("rep_new_password")).sendKeys("password");

    WebElement dragElement = driver.findElement(By.className("clippy"));
    Actions builder = new Actions(driver);
    builder.dragAndDropBy(dragElement, 100, 0).build().perform();

    driver.findElement(By.id("management_save")).click();
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
