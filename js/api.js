// Supabase initialization
const supabaseUrl = 'https://xszzuzkbhgzriibfunvl.supabase.co';
const supabaseKey = 'sb_publishable_dFykLS7AhF_V9QxvUEhXJQ_htqiv0Tr';
export const supabaseClient = supabase.createClient(supabaseUrl, supabaseKey);

console.log("Supabase Client Initialized:", supabaseClient);
