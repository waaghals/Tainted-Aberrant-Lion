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

public class RegisterTest extends TestCase {
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
  public void testRegister() throws Exception {
    driver.get(baseUrl + "/");
    driver.findElement(By.xpath("//button[@onclick='location.href = \"/account/Register\"']")).click();
    driver.findElement(By.name("username")).clear();
    driver.findElement(By.name("username")).sendKeys("sdijk4");
    driver.findElement(By.name("password")).clear();
    driver.findElement(By.name("password")).sendKeys("sdijk4");
    driver.findElement(By.name("passwordagain")).clear();
    driver.findElement(By.name("passwordagain")).sendKeys("sdijk4");
    driver.findElement(By.name("email")).clear();
    driver.findElement(By.name("email")).sendKeys("samsam_31393@hotmail.com");
    driver.findElement(By.name("firstname")).clear();
    driver.findElement(By.name("firstname")).sendKeys("Sam");
    driver.findElement(By.name("surname")).clear();
    driver.findElement(By.name("surname")).sendKeys("van Dijk");
    driver.findElement(By.name("city")).clear();
    driver.findElement(By.name("city")).sendKeys("Tilburg");
    driver.findElement(By.name("zipcode")).clear();
    driver.findElement(By.name("zipcode")).sendKeys("5042GE");
    driver.findElement(By.name("street")).clear();
    driver.findElement(By.name("street")).sendKeys("Bokhamerstraat");
    driver.findElement(By.name("streetnumber")).clear();
    driver.findElement(By.name("streetnumber")).sendKeys("26");
    driver.findElement(By.name("registrationcode")).clear();
    driver.findElement(By.name("registrationcode")).sendKeys("24f38a16d81a5a4662c8efc0a1fc879aaba9b051");
    driver.findElement(By.id("register_button")).click();
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
