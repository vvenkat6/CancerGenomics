#!/usr/bin/env python

'''
Program that analysis a patient vcf to:
	a)Write tables for:
		>Gene counts of the top 25 genes in the vcf file (if vcf file is annotated with gene name)
		>Genes from the patient file that exist in the ovarian cancer database
	b)Plot Graphs for:
		>Top 25 most occuring gene in patient vcf (if vcf file is annotated)
		>Muatation type vs cosmic score, colored by database
		>Gene name vs cosmic score, colored by mutation type

usage:
./vcf_analyze.py <vcf_file>

Dependent python packages:
	1)pyvcf
	2)matplotlib
	3)seaborn

Dependent files:
	DATABASE folder that contains the database files in the current directory
Comment: Program has been tested on python 2.7
'''

import vcf
import csv
import sys
import os
import matplotlib
matplotlib.use('Agg')
from matplotlib import pyplot as plt
import seaborn as sns; sns.set(color_codes=True)
import pandas as pd
import operator
import numpy as np

if len(sys.argv) < 2 or len(sys.argv) > 2:
	print "\nIncorrect usage of program!\n"
	print "Usage: ./vcf_analyze.py <vcf_file>\n"
	sys.exit()

vcf_reader = vcf.Reader(open(sys.argv[1]),'r')
patient_dict = dict()
temp = os.path.splitext(os.path.basename(sys.argv[1]))
name = temp[0]
annotate = 1

#vcfGenePlotter.py
gene_count = dict()
for record in vcf_reader:
        if record.QUAL > 29:
		try:
                	for name in record.INFO['Gene.refGene']:
                        	if name == None:
                                	name = 'NONE'
                        	if name in gene_count:
                                	gene_count[name] += 1
                        	else:
                                	gene_count[name] = 0
		except:
			print "Unannotated file\n"
			annotate = 0
			break
count = 0
if(annotate):
	with open(name+'_GeneCount.tsv','w') as o:
        	for count,record in enumerate(sorted(gene_count.items(), key=operator.itemgetter(1), reverse=True)):
                	if count <= 25:
                        	o.write('{0}\t{1}\n'.format(record[0],record[1]))
                	else:
                        	break

	o.close()

if (annotate) :
	#GenePlotter.py
	sns.set(style="white", context="talk")
	rs = np.random.RandomState(7)

	# Set up the matplotlib figure
	f, (ax3) = plt.subplots(1,1, figsize=(8, 6),sharex=True)

	inp = csv.reader(open(name+'_GeneCount.tsv'),delimiter='\t')
	x = list()
	y3 = list()
	for lines in inp:
        	x.append(lines[0])
        	y3.append(int(lines[1]))
	sns.barplot(x, y3, palette="Set3", ax=ax3)
	ax3.set_ylabel("Number of Mutations")
	ax3.set_xlabel("Genes")
	# Finalize the plot
	sns.despine(bottom=True)
	#plt.setp(f.axes, yticks=[])
	plt.tight_layout(h_pad=3)
	plt.xticks(rotation=75,size=8)
	plt.gcf().subplots_adjust(bottom=0.15)
	plt.savefig(name+'TopGeneCount')


#vcfParser.py
handle = open(name+'.tsv','w')
file = csv.writer(handle,delimiter="\t")

for record in vcf_reader:
        if(record.QUAL >= 30):
                patient_dict[record.POS] = []
                patient_dict[record.POS].append(record.REF)
                patient_dict[record.POS].append(str(record.ALT[0]))

file.writerow(["Gene","Start","Variant_Classification","Amino_Acid_change","Validation_Status","Cosmic","Color"])

with open("./DATABASE/Main_database.tsv") as csvfile:
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

with open("./DATABASE/BRCA1_Gold") as csvfile:
        linereader = csv.reader(csvfile, delimiter='\t')
        linereader.next()
        for line in linereader:
                if line[9] != 'Error':
                        if int(line[9]) in patient_dict:
                                print "BRCA1\t"+line[9]+"\t"+line[1]+"\t"+line[3]+"\tValid\t0.99\tGold"
                                file.writerow(["BRCA1",line[9],line[1],line[3],"Valid","0.99","Gold"])

with open("./DATABASE/BRCA2_Gold") as csvfile:
        linereader = csv.reader(csvfile, delimiter='\t')
        linereader.next()
        for line in linereader:
                if line[9] != 'Error':
                        if int(line[9]) in patient_dict:
                                print "BRCA2\t"+line[9]+"\t"+line[1]+"\t"+line[3]+"\tValid\t0.99\tGold"
                                file.writerow(["BRCA2",line[9],line[1],line[3],"Valid","0.99","Gold"])

with open("./DATABASE/BARD1_Gold") as csvfile:
        linereader = csv.reader(csvfile, delimiter='\t')
        linereader.next()
        for line in linereader:
                if line[9] != 'Error':
                        if int(line[9]) in patient_dict:
                                print "BARD1\t"+line[9]+"\t"+line[1]+"\t"+line[3]+"\tValid\t0.99\tGold"
                                file.writerow(["BARD1",line[9],line[1],line[3],"Valid","0.99","Gold"])

handle.close()

#query_db2.py
test = pd.read_csv(name+'.tsv',sep='\t')

print "Generating MutationType vs Cosmic score graph"
hue_ord = list(set(test.Variant_Classification))
plt.figure(figsize=(12,12))
plt.title('Mutation type vs Cosmic Score',size=14)
sns.stripplot(x='Gene',y='Cosmic',hue='Variant_Classification',edgecolor='black',data=test,jitter=True,split=True)
plt.legend(loc='center left', bbox_to_anchor=(1, 0.5))
plt.xticks(rotation=90,size=14)
plt.yticks(size=14)
plt.savefig(name+'_MutationType')

#query_db.py
print "Generating Genes vs Cosmic score graph"
test2 = pd.read_csv(name+'.tsv',sep='\t')

plt.figure(figsize=(12,12))
plt.title('Genes vs Cosmic Score',size=14)
sns.stripplot(x='Variant_Classification',y='Cosmic',hue='Color',edgecolor='black',data=test2,jitter=True,palette={"Gold":"b","Main":"r"})
print "Graph plotted..."
plt.xticks(rotation=45,size=14)
print "Graph x axis"
plt.yticks(size=14)
print "Graph yticks"
plt.savefig(name+'_Genes')
print "graph saved"

