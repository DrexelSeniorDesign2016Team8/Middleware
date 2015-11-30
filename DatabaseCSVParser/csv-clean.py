import sys
import csv

class Inst:
    def __init__(self, instId, name=None, address=None, city=None, phone=None, zipcode=None, admission=None, state=None, instType=None, retenRate=None, size=None, reading=None, writing=None, math=None, act=None):
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

    def getInstRow(self):
        return "%s,%s,%s,%s,%s,US,%s,%s,20,%s,none,%s,%s,%s" % (self.instId,self.name,self.address,self.city,self.state,self.size,self.zipcode,self.retenRate,self.admission,self.phone,self.instType)

    def getScoreRow(self):
        return "%s,00,3.0,%s,%s,%s" % (self.instId,self.math,self.reading,self.act)

def getCSVData():
    insts = []
    f = open(sys.argv[1],"r")
    lines_list = f.readlines()

    for line in lines_list:
        temp = line.split(',')
        print(temp)
        if temp[0] != "unitid":
            zipcode = temp[5].split('-')[0]
            while len(zipcode) != 5:
                zipcode = "0" + zipcode
            tempInst = Inst(temp[0],temp[1],temp[2],temp[3],temp[6].replace(" ",""),zipcode,temp[8],temp[4],temp[7],temp[9],temp[14].strip('\n').strip('\r'),temp[10],temp[12],temp[11],temp[13])
            insts.append(tempInst)
    return insts

insts = getCSVData()
f = open('institutions.csv','w')
f.write("ID,Name,Address,City,State,Country,Population,ZIP,ClassSize,Retention,Image,Acceptance,Phone,Type\n")
for inst in insts:
    f.write("%s\n" % (inst.getInstRow()))
f.close()
f = open('institutions_scores.csv','w')
f.write("InstID,Walk,GPA,SATMath,SATReading,ACT\n")
for inst in insts:
    f.write("%s\n" % (inst.getScoreRow()))
f.close()
