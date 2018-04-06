#!/usr/bin/env python3

import sys, threading, time, os, urllib, re, requests, pymysql
from html.parser import HTMLParser
from urllib import request
from xml.dom import minidom
from bs4 import BeautifulSoup
from xml.dom.minidom import parse
import xml.etree.ElementTree as ET

# HEADERS CONFIG
headers = {
        'User-Agent': 'Mozilla/5.1 (Macintosh; Intel Mac OS X 10.9; rv:43.0) Gecko/20100101 Firefox/43.0'
      }

file = open('dat.html', 'w')

def parseMails(uid):
	page = 'https://profile.onliner.by/user/'+str(uid)+''
	cookie = {'onl_session': 'YOUR_SESSION_COOOKIE_HERE'}
	r = requests.get(page, headers = headers, cookies = cookie)
	data = BeautifulSoup(r.text)
	userinfo = data.find_all('dl', {'class': 'uprofile-info'})
	find_email = []
	for item in userinfo:
		find_email += str(item.find('a'))
		#detect_email = re.compile("(\w+[.|\w])*@(\w+[.])*\w+").search(str(find_email))
	get_mail = ''.join(find_email)
	detect_email = re.compile(".+?>(.+@.+?)</a>").search(get_mail)
	file.write("<li>('"+detect_email.group(1)+"', 'onliner', 'belarus'),</li>")

for uid in range(1500001, 1800000):
	t = threading.Thread(target=parseMails, args=(uid,))
	t.start()
	time.sleep(0.3)
