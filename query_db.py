#!/usr/bin/python

import matplotlib
matplotlib.use('Agg')
from matplotlib import pyplot as plt
import seaborn as sns; sns.set(color_codes=True)
import pandas as pd

#sns.set(style="whitegrid", palette="pastel")
print "Generating graph..."
test = pd.read_csv('newfile.txt',sep='\t')

plt.figure(figsize=(12,12))
plt.title('Mutation type vs Cosmic Score',size=14)
sns.stripplot(x='Variant_Classification',y='Cosmic',hue='Color',edgecolor='black',data=test,jitter=True,palette={"Gold":"b","Main":"r"})
print "Graph plotted..."
plt.xticks(rotation=45,size=14)
print "Graph x axis"
plt.yticks(size=14)
print "Graph yticks"
plt.savefig('testeshwar')
print "graph saved"
