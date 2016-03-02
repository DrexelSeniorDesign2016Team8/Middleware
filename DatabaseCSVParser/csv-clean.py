import sys
import csv
import re
from random import randint,uniform

class Inst:
    def __init__(self, instId, name=None, address=None, city=None, phone=None, zipcode=None, admission=None, state=None, instType=None, retenRate=None, size=None, reading=None, writing=None, math=None, act=None, url=None):
        self.instId = instId
        self.name = name
        self.city = city
        self.phone = phone
        self.address = address
        self.zipcode = zipcode
        self.admission = admission
        self.state = state
        self.instType = instType
        self.retenRate = retenRate
        self.size = size
        self.reading = reading
        self.writing = writing
        self.math = math
        self.act = act
        self.url = url

    def getInstRow(self):
        classSize = randint(5,50)
        return "%s,%s,%s,%s,%s,US,%s,%s,%s,%s,none,%s,%s,%s,%s" % (self.instId,self.name,self.address,self.city,self.state,self.size,self.zipcode,str(classSize),self.retenRate,self.admission,self.phone,self.instType,self.url)

    def getScoreRow(self):
        GPA = round(uniform(2.5, 3.5),2)
        return "%s,00,%s,%s,%s,%s" % (self.instId,str(GPA),self.math,self.reading,self.act)

def cleanInstName(institution):
    institution = re.sub('[^A-Za-z0-9]+', '', institution).lower()
    return institution
    
def getInstWebsites():
    f = open("university_websites.txt","r")
    inst_websites = {}
    lines_list = f.readlines()
    for line in lines_list:
        temp = line.split(',')
        if len(temp) != 1:
            inst_websites[cleanInstName(temp[1])] = temp[0]
    return inst_websites


def getCSVData():
    insts = []
    f = open("collegedata.csv","r")
    lines_list = f.readlines()
    inst_websites = getInstWebsites()
    for line in lines_list:
        temp = line.split(',')
        if temp[0] != "unitid":
            zipcode = temp[5].split('-')[0]
            while len(zipcode) != 5:
                zipcode = "0" + zipcode
            url = inst_websites.get(cleanInstName(temp[1]),"N/A")
            tempInst = Inst(temp[0],temp[1],temp[2],temp[3],temp[6].replace(" ",""),zipcode,temp[8],temp[4],temp[7],temp[9],temp[14].strip('\n').strip('\r'),temp[10],temp[12],temp[11],temp[13],url)
            insts.append(tempInst)
    return insts

insts = getCSVData()
f = open('institutions.csv','w')
f.write("ID,Name,Address,City,State,Country,Population,ZIP,ClassSize,Retention,Image,Acceptance,Phone,Type,URL\n")
for inst in insts:
    f.write("%s\n" % (inst.getInstRow()))
f.close()
f = open('institutions_scores.csv','w')
f.write("InstID,Walk,GPA,SATMath,SATReading,ACT\n")
for inst in insts:
    f.write("%s\n" % (inst.getScoreRow()))
f.close()
