import requests
from bs4 import BeautifulSoup
import pandas as pd
import time
import os
from selenium import webdriver

fp = webdriver.FirefoxProfile()
# 0:デスクトップ、1:システム規定のフォルファ、2:ユーザ定義フォルダ
fp.set_preference("browser.download.folderList",2)
# 上記で2を選択したのでファイルのダウンロード場所を指定
fp.set_preference("browser.download.dir", os.getcwd() + "/data")
# ダウンロード完了時にダウンロードマネージャウィンドウを表示するかどうかを示す真偽値。
fp.set_preference("browser.download.manager.showWhenStarting",False)
# mimeタイプを設定
fp.set_preference("browser.helperApps.neverAsk.saveToDisk", "application/octet-stream")


base = "https://disclosure.edinet-fsa.go.jp/E01EW/BLMainController.jsp?uji.verb=W1E63010CXW1E6A010DSPSch&uji.bean=ee.bean.parent.EECommonSearchBean&TID=W1E63011&PID=W1E63010&SESSIONKEY=1538717569222&lgKbn=2&pkbn=0&skbn=0&dskb=&dflg=0&iflg=0&preId=1&row=100&idx=0&syoruiKanriNo=&mul=%s&fls=on&cal=1&era=H&yer=&mon=&pfs=5"

# def get_soup(url):
#     resp = requests.get(url)
#     soup = BeautifulSoup(resp.text, "html.parser")
#     return soup

def get_codes():
    df = pd.read_csv("codes.csv")
    return df


if __name__ == '__main__':
    df = get_codes()
    driver = webdriver.Firefox(firefox_profile=fp)
    for index, item in df[:1].iterrows():
        keyword = item["code"]
        url = base % (keyword,)
        print(url)
        driver.get(url)
        for ele in driver.find_elements_by_xpath('//table[@class="resultTable table_cellspacing_1 table_border_1 mb_6"]//tr/td[7]//a'):
            ele.click()

    driver.close()
