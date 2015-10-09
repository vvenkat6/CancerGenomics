#!/usr/bin/env python

import csv
import subprocess
import os.path
import sys

gene = sys.argv[-1].upper()

print "Start\tVariant_Classification\tAmino_Acid_change\tValidation_Status\tCosmic\tColor"

gold = dict()
if (os.path.exists("/home/vaishnavi/data/DATABASE/"+gene.upper()+"_Gold")):
	with open("/home/vaishnavi/data/DATABASE/"+gene.upper()+"_Gold") as csvfile:
		linereader = csv.reader(csvfile, delimiter='\t')
		linereader.next()
		for line in linereader:
			gold[line[9]] = line
			if line[9] != "Error":
				print line[9]+"\t"+line[1]+"\t"+line[3]+"\tValid\t0.99\tGold"
				#file.writerow([line[9],line[1],line[3],"Valid","0.99","Gold"])
						
with open("/home/vaishnavi/data/DATABASE/Main_database.tsv") as csvfile:
	linereader = csv.reader(csvfile, delimiter='\t')
	for line in linereader:
		if gene.upper() in line:
			if line[54] == 'NA' or line[54] == '':
				line[54] = "0"
				
			if line[2] in gold:
				v = 1
					#print "BRCA1\t\t"+gold[line[2]][9]+"\t\t"+gold[line[2]][1]+"\t\t-\t\t"+gold[line[2]][3]+"\t\tValid\t\t0.99"
			else:
				if line[8] == "Frame_Shift_Ins":
                                        line[8] = "Insertion"
                                elif line[8] == "Frame_Shift_Del":
                                        line[8] = "Deletion"
                                elif line[8] == "Missense_Mutation":
                                        line[8] = "Missense"
				elif line[8] == "Nonsense_Mutation":
					line[8] = "Nonsense"
				elif line[8] == "In_Frame_Ins":
					line[8] = "Insertion"
				elif line[8] == "In_Frame_Del":
					line[8] = "Deletion"
				elif line[8] == "Splice_Site":
					line[8] = "Splice Site"
				elif line[8] == "Splice_Region":
					line[8] = "Splice Site"

				print line[2]+"\t"+line[8]+"\t"+line[47]+"\t"+line[24]+"\t"+line[54]+"\tMain"
				#file.writerow([line[2],line[8],line[47],line[24],line[54],"Main"]) 
#handle.close()

