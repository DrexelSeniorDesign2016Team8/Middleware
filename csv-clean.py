import sys
import csv

class Inst:
    def __init__(self, instId, name=None, address=None, zipcode=None, admission=None, state=None, instType=None, retenRate=None, size=None, reading=None, writing=None, math=None, act=None):
        self.instId = instId
        self.name = name
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

    def getInstRow():
        temp = []
        temp.append(self.instId)
        temp.append(self.name)
        temp.append(self.address)
        temp.append(
