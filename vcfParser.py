#!/usr/bin/env python

import vcf
import csv

vcf_reader = vcf.Reader(open('./uploads/588r.vcf'),'r')
#vcf_reader = vcf.Reader(open('test.vcf'),'r')
patient_dict = dict()
handle = open('gene_db.tsv','w')
file = csv.writer(handle,delimiter="\t")

for record in vcf_reader:
        if(record.QUAL >= 30):
                patient_dict[record.POS] = []
                patient_dict[record.POS].append(record.REF)
                patient_dict[record.POS].append(str(record.ALT[0]))

#print "The number of mutations this person has is: "
#print len(patient_dict)
#print

print "Gene\tStart\tVariant_Classification\tAmino_Acid_change\tValidation_Status\tCosmic\tColor"

with open("/home/vaishnavi/data/DATABASE/Main_database.tsv") as csvfile:
        linereader = csv.reader(csvfile, delimiter='\t')
        for line in linereader:
                if int(line[1]) in patient_dict:
                        if line[8] == "Frame_Shift_Ins":
                                line[8] = "Insertion"
                        if line[8] == "In_Frame_Ins":
                                line[8] = "Insertion"
                        elif line[8] == "Frame_Shift_Del":
                                line[8] = "Deletion"
                        elif line[8] == "Missense_Mutation":
                                line[8] = "Missense"
                        elif line[8] == "Nonsense_Mutation":
                                line[8] = "Nonsense"
			
			if line[54] == "NA" or line[54] == "":
				line[54] = "0"
			
                        print line[3]+"\t"+line[2]+"\t"+line[8]+"\t"+line[47]+"\t"+line[24]+"\t"+line[54]+"\tMain"
                        file.writerow([line[3],line[2],line[8],line[47],line[24],line[54],"Main"]) 


with open("/home/vaishnavi/data/DATABASE/BRCA1_Gold") as csvfile:
        linereader = csv.reader(csvfile, delimiter='\t')
        linereader.next()
        for line in linereader:
                if line[9] != 'Error':
                        if int(line[9]) in patient_dict:
                                print "BRCA1\t"+line[9]+"\t"+line[1]+"\t"+line[3]+"\tValid\t0.99\tGold"
                                file.writerow(["BRCA1",line[9],line[1],line[3],"Valid","0.99","Gold"])

with open("/home/vaishnavi/data/DATABASE/BRCA2_Gold") as csvfile:
        linereader = csv.reader(csvfile, delimiter='\t')
        linereader.next()
        for line in linereader:
                if line[9] != 'Error':
                        if int(line[9]) in patient_dict:
                                print "BRCA2\t"+line[9]+"\t"+line[1]+"\t"+line[3]+"\tValid\t0.99\tGold"
                                file.writerow(["BRCA2",line[9],line[1],line[3],"Valid","0.99","Gold"])

with open("/home/vaishnavi/data/DATABASE/BARD1_Gold") as csvfile:
        linereader = csv.reader(csvfile, delimiter='\t')
        linereader.next()
        for line in linereader:
                if line[9] != 'Error':
                        if int(line[9]) in patient_dict:
                                print "BARD1\t"+line[9]+"\t"+line[1]+"\t"+line[3]+"\tValid\t0.99\tGold"
                                file.writerow(["BARD1",line[9],line[1],line[3],"Valid","0.99","Gold"])


