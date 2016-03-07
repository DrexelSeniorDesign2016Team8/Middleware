import sys
import csv
import re
from random import randint,uniform

class Inst:
    def __init__(self, instId, name=None, address=None, city=None, phone=None, zipcode=None, admission=None, state=None, instType=None, retenRate=None, size=None, reading=None, writing=None, math=None, act=None, url=None, commonapp=None, gpa=None, classsize=None):
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
        self.commonapp = commonapp
        self.gpa = gpa
        self.classsize = classsize

    def getInstRow(self):
        classSize = randint(5,50)
        return "%s,%s,%s,%s,%s,US,%s,%s,%s,%s,none,%s,%s,%s,%s,%s" % (self.instId,self.name,self.address,self.city,self.state,self.size,self.zipcode,self.classsize,self.retenRate,self.admission,self.phone,self.instType,self.commonapp,self.url)

    def getScoreRow(self):
        return "%s,00,%s,%s,%s,%s,%s" % (self.instId,self.gpa,self.math,self.reading,self.writing,self.act)

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

def getCommonApps():
    f = open("Common_Application.csv","r")
    inst_commonApp = {}
    lines_list = f.readlines()
    for line in lines_list:
        temp = line.split(',')
        inst_commonApp[cleanInstName(temp[0].strip('\n').strip('\r'))] = 1
    return inst_commonApp

def getClassSize():
    f = open("ClassSizeData.csv","r")
    inst_classsize = {}
    lines_list = f.readlines()
    for line in lines_list:
        temp = line.split(',')
        inst_classsize[cleanInstName(temp[0])] = temp[1].strip('\n').strip('\r')
    return inst_classsize

def getAverageGPA():
    f = open("MoreData.csv","r")
    inst_GPA = {}
    lines_list = f.readlines()
    for line in lines_list:
        temp = line.split(',')
        if len(temp) != 1:
            if temp[6] != "":
                inst_GPA[cleanInstName(temp[0])] = temp[6].strip('\n').strip('\r')
            else:
                inst_GPA[cleanInstName(temp[0])] = str(round(uniform(2.5, 3.5),2))
    return inst_GPA

def getCSVData():
    insts = []
    f = open("collegedata.csv","r")
    lines_list = f.readlines()
    inst_websites = getInstWebsites()
    inst_commonApp = getCommonApps()
    inst_classsize = getClassSize()
    inst_GPA = getAverageGPA()
    for line in lines_list:
        temp = line.split(',')
        if temp[0] != "unitid":
            zipcode = temp[5].split('-')[0]
            while len(zipcode) != 5:
                zipcode = "0" + zipcode
            name = cleanInstName(temp[1])
            url = inst_websites.get(name,"N/A")
            commonApp = inst_commonApp.get(name,"0")
            classsize = inst_classsize.get(name,str(randint(5,50)))
            gpa = inst_GPA.get(name,"0")
            if gpa == "0":
                gpa = str(round(uniform(2.5, 3.5),1))
            else:
                gpa = "{0:.1f}".format(float(gpa))
            tempInst = Inst(temp[0],temp[1],temp[2],temp[3],temp[6].replace(" ",""),zipcode,temp[8],temp[4],temp[7],temp[9],temp[14].strip('\n').strip('\r'),temp[10],temp[12],temp[11],temp[13],url,commonApp,gpa,classsize)
            insts.append(tempInst)
    return insts

insts = getCSVData()
f = open('institutions.csv','w')
f.write("ID,Name,Address,City,State,Country,Population,ZIP,ClassSize,Retention,Image,Acceptance,Phone,Type,CommonApp,URL\n")
for inst in insts:
    f.write("%s\n" % (inst.getInstRow()))
f.close()
f = open('institutions_scores.csv','w')
f.write("InstID,Walk,GPA,SATMath,SATReading,SATWriting,ACT\n")
for inst in insts:
    f.write("%s\n" % (inst.getScoreRow()))
f.close()
