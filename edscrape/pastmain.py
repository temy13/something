import requests
from bs4 import BeautifulSoup
from selenium import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.action_chains import ActionChains
import time
import sys
import pandas as pd
import traceback
from datetime import datetime
from glob import glob

host = "https://www.kensetsu-databank.co.jp"

driver = webdriver.Chrome()
driver.set_page_load_timeout(60)
actions = ActionChains(driver)

registered = set([])
def load():
    global registered
    for fn in glob("data/*.csv"):
        df = pd.read_csv(fn)
        for i, row in df.iterrows():
            registered.add(row[1]+"_"+row[2]+"_"+row[3])



def page(p):
    #elements = driver.find_elements_by_xpath("//table[@class='ichi']")
    elements = driver.find_elements_by_xpath("//table[@class='ichi']/tbody/tr")
    #elements = driver.find_elements_by_xpath("//table[@class='ichi']/tbody/tr/td/a")
    result = []
    if not elements:
        return result
    for i, ele in enumerate(elements[:20]):
        a = ele.find_elements_by_xpath(".//td/a")
        if not a:
            continue
        tds = ele.find_elements_by_xpath(".//td")
        key = tds[0].text + "_" + tds[1].text + "_" + tds[2].text
        if key in registered:
            continue
        trycount = 3
        while(trycount > 0):
            try:
                time.sleep(5)
                a[0].click()
                #ele.click()
                main_window = driver.current_window_handle
                target = [w for w in driver.window_handles if w != main_window][0]
                driver.switch_to.window(target)

                html = driver.page_source
                soup = BeautifulSoup(html, "html.parser")
                tables = soup.find_all("table", class_="san-two")
                for t in tables:
                    texts = [tr.find_all("td")[1].getText() for tr in t.find_all("tr") if len(tr.find_all("td")) >= 2]
                    if len(texts) is not 23:
                        continue
                    result.append(texts)
                driver.close()
                driver.switch_to.window(main_window)
                trycount = 0
            except selenium.common.exceptions.TimeoutException as e:
                trycount -= 1
                print("rest count", trycount, "page", p, "index", i)
            except Exception as e:
                print("page",p,"index",i)
                traceback.print_exc()
                trycount = 0
    return result


def get_data():
    result = []
    p = 0
    try:
        while(True):
            r = page(p)
            if not r:
                break
            result.extend(r)
            btn = driver.find_element_by_xpath("//input[@value='次の100件を表示　＞＞']")
            break
            if btn:
                btn.click()
            else:
                break
            p += 1
            time.sleep(5)
    except:
        traceback.print_exc()

    print("result", len(result))
    ddf =  pd.DataFrame(data=result, columns=[
        "KDB", "届出日", "件名", "地名地番", "住居表示", "主要用途", "工事種別", "構造", "基礎", "階数（地上）", "階数（地下）", "延床面積",
        "建築面積", "敷地面積", "建築主", "建築主住所", "設計者", "設計者住所", "施工者", "施工者住所", "着工", "完成", "備考"
    ])
    fn = "b_" + datetime.now().strftime("%Y%m%d%H%M%S")
    print(len(result))
    ddf.to_csv("data/" + fn +".csv", index=False)
    #ddf.to_excel(fn +".xlsx", index=False)

def main(s = "/kensaku/"):
    result = []
    url = host + s
    driver.get(url)
    driver.find_element_by_xpath("//input[@id='s-tokyo23']").click()
    driver.find_element_by_xpath("//input[@id='y-yokohama18']").click()
    driver.find_element_by_xpath("//input[@id='k-kawasaki07']").click()
    driver.find_element_by_xpath("//input[@value='戸建住宅']").click()
    driver.find_element_by_xpath("//form[@action='result.php']/p/input[@type='submit']").click()
    time.sleep(5)
    get_data()
    print("done")
    # driver.find_element_by_xpath("//input[@type='submit']").click()

if __name__ == '__main__':
    load()
    main("/kensaku/")#6302
    # main("/shutoken2009-2013/kensaku/")#6734
    driver.quit()
