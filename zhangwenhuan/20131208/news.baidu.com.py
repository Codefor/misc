#!/bin/env python
#encoding=utf8

import sys   
reload(sys) 
sys.setdefaultencoding('utf-8')   

import requests
import json
import time


from BeautifulSoup import BeautifulSoup 

for i in xrange(0,60,10):
    url = "http://news.baidu.com/ns?word=移动视频基地&tn=newstitle&pn=%s" % i

    res = requests.get(url)
    if res.status_code == 200:
	t = BeautifulSoup(res.text)

	for j in t.findAll("li",{"class":"result title"}):
	    a = j.find("a")
	    dt = j.find("span").text
	    r = "%s,%s,%s" % (a["href"],a.text.encode("utf-8"),dt.replace("&nbsp;",""))
	    print r.encode("utf8")

    	for j in t.findAll("li",{"class":"result title titlelast"}):
	    a = j.find("a")
	    dt = j.find("span").text
	    r = "%s,%s,%s" % (a["href"],a.text.encode("utf-8"),dt.replace("&nbsp;",""))
	    print r.encode("utf8")
