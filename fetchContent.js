const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto(process.argv[2], { waitUntil: 'networkidle2' });

    // Wait for content (optional: depending on what you need)
    // await page.waitForSelector('#someSelector');

    const content = await page.content(); // Get the fully rendered HTML

    console.log(content);

    await browser.close();
})();
